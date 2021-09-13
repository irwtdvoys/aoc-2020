<?php
	const ROOT = __DIR__ . "/../";

	require_once(CRUXOFT_ROOT . "bin/init.php");

	use App\MemoryGame;

	$helper = new MemoryGame(15);//, ROOT . "data/14/examples/02");
	$helper->run()->output();

	// Part 1: 1009
	// Part 2: 62704
?>
