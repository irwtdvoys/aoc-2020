<?php
	namespace App\JurassicJigsaw;

	class Cell
	{
		public ?Cell $top = null;
		public ?Cell $right = null;
		public ?Cell $bottom = null;
		public ?Cell $left = null;

		public ?Tile $tile = null;

		public function __construct(Tile $tile)
		{
			$this->tile = $tile;
		}
	}
?>
