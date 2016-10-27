<?php
	spl_autoload_register(function($class) {
		require $class.'.php';
	});

	session_start();

	require_once 'config.php';

	if (isset($_GET['log_out']))
		unset($_SESSION['brute']);
	if (isset($_SESSION['brute']))
		$brute = $_SESSION['brute'];

	$db = new PDO('mysql:host='.$db_host.';dbname='.$db_name, $db_user, $db_pswd);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	$manager = new BrutesManager($db);

	//If we create a Brute
	if (isset($_POST['create']) && isset($_POST['name'])) {
		switch ($_POST['type']) {
			case 'warrior':
				$brute = new Warrior(['name' => $_POST['name']]);
				break;
			case 'wizard':
				$brute = new Wizard(['name' => $_POST['name']]);
				break;
			default:
				$message = 'Brute type is invalid.';
				break;
		}
		if (isset($brute)) {
			if (!$brute->valid_name()) {
				$message = 'This is an invalid name.';
				unset($brute);
			}
			elseif ($manager->exists($brute->get_name())) {
				$message = 'This particular Brute already exists.';
				unset($brute);
			}
			else
				$manager->add($brute);
		}
	}

	//If we use a Brute
	elseif (isset($_POST['use']) && isset($_POST['name'])) {
		if ($manager->exists($_POST['name']))
			$brute = $manager->get($_POST['name']);
		else
			$message = 'This brute does not yet exist!';
	}

	//If we hit a Brute
	elseif (isset($_GET['hit'])) {
		if (!isset($brute))
			$message = 'Please create a Brute or use one.';
		else {
			if (!$manager->exists((int) $_GET['hit']))
				$message = 'The Brute you want to hit doesn’t exist!';
			else {
				$brute_to_hit = $manager->get((int) $_GET['hit']);
				$back = $brute->hit($brute_to_hit);
				switch ($back) {
					case Brute::TARGET_INVALID:
						$message = 'Invalid target';
						break;
					case Brute::TARGET_HIT:
						$message = 'You hit it!';
						$brute->gain_xp($brute, 2);
						$brute_to_hit->gain_xp($brute_to_hit, 1);
						$manager->update($brute);
						$manager->update($brute_to_hit);
						break;
					case Brute::TARGET_DEAD:
						$message = 'You killed it!';
						$brute->gain_xp($brute, 3);
						$manager->update($brute);
						$manager->delete($brute_to_hit);
						break;
					case Brute::TARGET_ASLEEP:
						$message = 'Your Brute is asleep, you can’t hit anyone!';
						break;
				}					
			}
		}
	}

	elseif (isset($_GET['enchant'])) {
		if (!isset($brute))
			$message = 'Please create a Brute or use one.';
		else {
			//if brute is a wizard
			if ($brute->get_type() != 'wizard')
				$message = 'Only wizard can enchant Brutes!';
			else {
				if (!manager->exists((int) $_GET['enchant']))
					$message = 'The Brute you want to enchant doesn’t exist!';
				else {
					$brute_to_enchant = $manager->get((int) $_GET['enchant']);
					$back = $brute->cast_spell($brute_to_enchant);

					switch ($back) {
						case Brute::TARGET_INVALID:
							$message = 'You cannot enchant yourself.';
							break;
						case Brute::TARGET_SPELLED:
							$message = 'You enchanted it!';
							$manager->update($brute);
							$manager->update($brute_to_enchant);
							break;
						case Brute::TARGET_ASLEEP:
							$message = 'Your Brute is asleep, you can’t enchant anyone';
							break;
					}
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Brute Game v2</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<div>
			<h1>Brute Game</h1>
			<p>Number of Brutes created: <?= $manager->count() ?></p>
		</div>

		<?php if (isset($message))
			echo '<p>'.$message.'</p>';

			if (isset($brute)) {
		?>
		<div>
			<h2>My Brute</h2>
			<p>Name: <?= htmlspecialchars($brute->get_name()) ?></p>
			<p>Type: <?= ucfirst($brute->get_type()) ?></p>
			<p>Life: <?= $brute->get_life() ?></p>
			<p>Xp: <?= $brute->get_xp() ?><p>
			<p>Strength: <?= $brute->get_strength() ?></p>
			<p><a href="?log_out=1">Log out</a><p>
		</div>

		<div>
			<h2>All the other Brutes</h2>
			<?php
				$brutes = $manager->list($brute->get_name());
				if (empty($brutes))
					echo '<p>There is no one to hit, create a Brute!</p>';
				else {
					if ($brute->is_asleep())
						echo '<p>A Wizard has set you asleep! You will wake up in '.$brute->wake_up().'.</p>';
					else {
						foreach ($brutes as $a_brute) {
							echo '<p><a href="?hit='.$a_brute->get_id().'">'.htmlspecialchars($a_brute->get_name()).'</a> (life: '.$a_brute->get_life().', xp: '.$a_brute->get_xp().', strength: '.$a_brute->get_strength().', type: '.$a_brute->get_type().')';
							if ($brute->get_type() == 'wizard')
								echo ' <a href="?enchant='.$a_brute->get_id().'">Cast a spell</a>';
							echo '</p>';
						}
					}
				}
			?>
		</div>
		<?php 
			} else {
		?>

		<form method="post" action="" id="form">
			<label for="name">Name:</label>
			<input id="name" name="name" type="text" />
			<button form="form" name="use" type="submit">Use this Brute</button>
			<label for="type">Type:</label>
			<select name="type">
				<option value="warrior">Warrior</option>
				<option value="wizard">Wizard</option>
			</select>
			<button form="form" name="create" type="submit">Create this Brute</button>
		</form>
		<h2>Brutes created</h2>
		<?php
			$brutes = $manager->list_all();
			if (empty($brutes))
				echo '<p>There is no brutes created, hurry create your Brute!</p>';
			else {
				foreach ($brutes as $brute)
					echo '<p>'.$brute->get_name().'</p>';
			}
		?>

		<?php
			}
		?>
	</body>
</html>
<?php if (isset($brute))
	$_SESSION['brute'] = $brute;
?>
