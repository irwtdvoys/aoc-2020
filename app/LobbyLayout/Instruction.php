<?php
	namespace App\LobbyLayout;

	class Instruction
	{
		public array $steps = [];

		public function __construct(string $data)
		{
			$this->steps = preg_split("/(e|se|sw|w|nw|ne)/", $data, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
		}
	}
?>
