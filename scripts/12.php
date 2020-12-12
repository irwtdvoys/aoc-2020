<?php
	ini_set("memory_limit", "8G");
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Ferry;

	$helper = new Ferry(12);//, ROOT . "data/12/example");
	$helper->run()->output();

	// Part 1: 923
	// Part 2: 24769
?>
