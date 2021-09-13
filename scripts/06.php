<?php
	const ROOT = __DIR__ . "/../";

	require_once(CRUXOFT_ROOT . "bin/init.php");

	use App\Customs;

	$helper = new Customs(6);//, ROOT . "data/06/example");
	$helper->run()->output();

	// Part 1: 826
	// Part 2: 678
?>
