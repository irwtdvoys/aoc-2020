<?php
	const ROOT = __DIR__ . "/../";

	require_once(CRUXOFT_ROOT . "bin/init.php");

	use App\Rfid;

	$helper = new Rfid(25);//, ROOT . "data/25/example");
	$helper->run()->output();

	// Part 1: 7936032
	// Part 2: N/A
?>
