<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Trajectory;

	$helper = new Trajectory(3);//, ROOT . "data/03/example");
	$helper->run()->output();

	// Part 1: 223
	// Part 2: 3517401300
?>
