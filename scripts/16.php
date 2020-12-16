<?php
	ini_set("memory_limit", "8G");
	define("ROOT", __DIR__ . "/../");

	require_once(ROOT . "bin/init.php");

	use App\TicketTranslation;

	$helper = new TicketTranslation(16, ROOT . "data/16/examples/01");
	$helper->run()->output();

	// Part 1: 1009
	// Part 2: 62704
?>
