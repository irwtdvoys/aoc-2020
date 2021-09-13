<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Luggage;

	$helper = new Luggage(7);//, ROOT . "data/07/example");
	$helper->run()->output();

	// Part 1: 208
	// Part 2: 1664
?>
