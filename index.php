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
		$brute = new Brute(['name' => $_POST['name']]);
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

	//If we use a Brute
	elseif (isset($_POST['use']) && isset($_POST['name'])) {
		if ($manager->exists($_POST['name']))
			$brute = $manager->get($_POST['name']);
		else
			$message = 'This brute does not yet exist!';
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Brute Game</title>
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
			<p>Life: <?= $brute->get_life() ?></p>
			<p><a href="?log_out=1">Log out</a><p>
		</div>

		<div>
			<h2>All the other Brutes</h2>
			<?php
				$brutes = $manager->get_list($brute->get_name());
				if (empty($brutes))
					echo '<p>There is no one to hit, create a Brute!</p>';
				else {
					foreach ($brutes as $a_brute)
						echo '<p><a href="?frapper='.$a_brute->get_id().'">'.htmlspecialchars($a_brute->get_name()).'</a> (life: '.$a_brute->get_life().')</p>';
				}
			?>
		</div>
		<?php 
			} else {
		?>

		<form method="post" action="" id="form">
			<label for="name">Name:</label>
			<input id="name" name="name" type="text" />
			<button form="form" name="create" type="submit">Create this Brute</button>
			<button form="form" name="use" type="submit">Use this Brute</button>
		</form>

		<?php
			}
		?>
	</body>
</html>
<?php if (isset($brute))
	$_SESSION['brute'] = $brute;
?>
