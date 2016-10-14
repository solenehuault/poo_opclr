<?php
	spl_autoload_register(function($class) {
		require $class.'.php';
	});

	require_once 'config.php';

	$db = new PDO('mysql:host='.$db_host.';dbname:='.$db_name, $db_user, $db_pswd);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

	$maneger = new BrutesManager($db);

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
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Brute Game</title>
		<meta charset="utf-8" />
	</head>
	<body>
		<h1>Brute Game</h1>
		<form method="post" action="">
			<label for="name">Name:</label>
			<input id="name" name="name" type="text" />
			<button form="form" name="create" type="submit">Create this Brute</button>
			<button form="form" name="use" type="submit">Use this Brute</button>
		</form>
	</body>
</html>
