<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\JurassicJigsaw\Cell;
	use App\JurassicJigsaw\Tile;

	class JurassicJigsaw extends Helper
	{
		public ?Cell $grid = null;
		public array $tiles = [];

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$raw = parent::load($override);

			$elements = explode(str_repeat(PHP_EOL, 2), $raw);

			foreach ($elements as $element)
			{
				preg_match("/Tile (?'id'[0-9]+):\n(?'content'[#|\.|\n]+)/", $element, $matches);

				$this->tiles[$matches['id']] = new Tile($matches['id'], $matches['content']);
			}
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$tile = (current($this->tiles));

			$tile->draw();
			echo(PHP_EOL);

			$tile->rotate(Tile::ROTATE_LEFT);
			$tile->draw();
			echo(PHP_EOL);

			$tile->rotate(Tile::ROTATE_RIGHT);
			$tile->draw();
			echo(PHP_EOL);

			return $result;
		}
	}
?>
