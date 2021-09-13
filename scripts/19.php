<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Messages;

	$helper = new Messages(19);//, ROOT . "data/19/examples/03");
	$helper->run()->output();

	// Part 1: 213
	// Part 2: 325
?>
