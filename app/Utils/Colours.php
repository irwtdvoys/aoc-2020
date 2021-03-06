<?php
	namespace App\Utils;

	class Colours
	{
		const BLACK = "0;30";
		const RED = "0;31";
		const GREEN = "0;32";
		const BROWN = "0;33";
		const BLUE = "0;34";
		const PURPLE = "0;35";
		const CYAN = "0;36";
		const LIGHT_GRAY = "0;37";

		const DARK_GRAY = "1;30";
		const LIGHT_RED = "1;31";
		const LIGHT_GREEN = "1;32";
		const YELLOW = "1;33";
		const LIGHT_BLUE = "1;34";
		const LIGHT_PURPLE = "1;35";
		const LIGHT_CYAN = "1;36";
		const WHITE = "1;37";

		public static function colour(string $string, string $colour)
		{
			return "\e[" . $colour . "m" . $string . "\033[0m";
		}
	}
?>
