<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\PassportProcessing;

	$helper = new PassportProcessing(4);//, ROOT . "data/04/example");
	$helper->run()->output();

	// Part 1: 202
	// Part 2: 137
?>
