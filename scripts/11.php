<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Seating;

	$helper = new Seating(11);//, ROOT . "data/11/example");
	$helper->run()->output();

	// Part 1: 2450
	// Part 2: 32396521357312
?>
