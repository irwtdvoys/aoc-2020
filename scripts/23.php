<?php
	ini_set("memory_limit", "256M");
	const ROOT = __DIR__ . "/../";

	require_once(CRUXOFT_ROOT . "bin/init.php");

	use App\CrabCups;

	$helper = new CrabCups(23);//, ROOT . "data/23/example");
	$helper->run()->output();

	// Part 1: 45983627
	// Part 2: 111080192688
?>
