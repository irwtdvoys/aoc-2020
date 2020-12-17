<?php
	ini_set("memory_limit", "8G");
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Conway;

	$helper = new Conway(17);//, ROOT . "data/17/example");
	$helper->run()->output();

	// Part 1: 223
	// Part 2: 1884
?>
