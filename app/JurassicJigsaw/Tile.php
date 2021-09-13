<?php
	namespace App\JurassicJigsaw;

	class Tile {
		public int $id;
		public array $data = [];

		public const FLIP_VERTICAL = 0;
		public const FLIP_HORIZONTAL = 1;
		public const ROTATE_LEFT = 0;
		public const ROTATE_RIGHT = 1;

		public function __construct(int $id, string $data)
		{
			$this->id = $id;

			$this->data = array_map(
				"str_split",
				explode(PHP_EOL, $data)
			);
		}

		public function draw(): void
		{
			echo("Tile " . $this->id . ":" . PHP_EOL);

			foreach ($this->data as $row)
			{
				echo(implode("", $row) . PHP_EOL);
			}
		}

		public function top(): string
		{
			return implode("", $this->data[0]);
		}

		public function bottom(): string
		{
			return strrev(implode("", $this->data[count($this->data) - 1]));
		}

		public function left(): string
		{
			return implode(
				"",
				array_map(
					function($row) {
						return $row[0];
					},
					$this->data
				)
			);
		}

		public function right(): string
		{
			return implode(
				"",
				array_map(
					function($row) {
						return $row[count($row) - 1];
					},
					$this->data
				)
			);
		}

		public function flip(int $direction): void
		{
			$this->data = match($direction)
			{
				self::FLIP_VERTICAL => array_reverse($this->data),
				self::FLIP_HORIZONTAL => array_map(
					function (array $element)
					{
						return array_reverse($element);
					},
					$this->data
				),
			};
		}

		public function rotate(int $direction): void
		{
			$this->data = match($direction)
			{
				self::ROTATE_LEFT => call_user_func_array(
					'array_map',
					array(-1 => null) + array_map('array_reverse', $this->data)
				),
				self::ROTATE_RIGHT => call_user_func_array(
					'array_map',
					array(-1 => null) + array_reverse($this->data)
				)
			};
		}
	}
?>
