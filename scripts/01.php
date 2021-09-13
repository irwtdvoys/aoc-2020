<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Report;

	$helper = new Report(1);//, ROOT . "data/01/examples/01");
	$helper->run()->output();

	// Part 1: 381699
	// Part 2: 111605670
?>
