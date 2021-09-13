<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Timetable;

	$helper = new Timetable(13);//, ROOT . "data/13/example");
	$helper->run()->output();

	// Part 1: 3385
	// Part 2: 600689120448303
?>
