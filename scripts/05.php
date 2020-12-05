<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Partitioning;

	$helper = new Partitioning(5);//, ROOT . "data/05/example");
	$helper->run()->output();

	// Part 1: 826
	// Part 2: 678
?>
