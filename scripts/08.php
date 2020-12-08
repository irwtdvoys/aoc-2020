<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Handheld;

	$helper = new Handheld(8);//, ROOT . "data/08/example");
	$helper->run()->output();

	// Part 1: 1586
	// Part 2: 703
?>
