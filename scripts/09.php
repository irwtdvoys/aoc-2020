<?php
	const ROOT = __DIR__ . "/../";

	require_once(CRUXOFT_ROOT . "bin/init.php");

	use App\Encoding;

	$helper = new Encoding(9);//, ROOT . "data/09/example");
	$helper->run()->output();

	// Part 1: 20874512
	// Part 2: 3012420
?>
