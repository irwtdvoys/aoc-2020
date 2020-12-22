<?php
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\CrabCombat;

	$helper = new CrabCombat(22);//, ROOT . "data/22/example");
	$helper->run()->output();

	// Part 1: 31455
	// Part 2: 32528
?>
