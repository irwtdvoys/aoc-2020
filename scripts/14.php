<?php
	ini_set("memory_limit", "8G");
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\Bitmasking;

	$helper = new Bitmasking(14);//, ROOT . "data/14/examples/02");
	$helper->run()->output();

	// Part 1: 14839536808842
	// Part 2: 4215284199669
?>
