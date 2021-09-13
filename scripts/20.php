<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\JurassicJigsaw;

	$day = 20;

	$helper = new JurassicJigsaw($day, CRUXOFT_ROOT . "data/" . $day . "/example");
	$helper->run()->output();

	// Part 1:
	// Part 2:
?>
