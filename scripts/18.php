<?php
	const ROOT = __DIR__ . "/../";

	require_once(ROOT . "bin/init.php");

	use App\Homework;

	$helper = new Homework(18);//, ROOT . "data/18/example");
	$helper->run()->output();

	// Part 1: 36382392389406
	// Part 2: 381107029777968
?>
