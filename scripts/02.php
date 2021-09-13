<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\PasswordPolicy;

	$helper = new PasswordPolicy(2);//, ROOT . "data/02/example");
	$helper->run()->output();

	// Part 1: 548
	// Part 2: 502
?>
