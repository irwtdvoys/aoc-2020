<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Joltage;

	$helper = new Joltage(10);//, ROOT . "data/10/examples/02");
	$helper->run()->output();

	// Part 1: 2450
	// Part 2: 32396521357312
?>
