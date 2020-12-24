<?php
	ini_set("memory_limit", "256M");
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\LobbyLayout;

	$helper = new LobbyLayout(24);//, ROOT . "data/24/example");
	$helper->run()->output();

	// Part 1: 293
	// Part 2: 3967
?>
