<?php
	namespace App\Utils;

	class Position3d extends Position2d
	{
		public int $z = 0;

		public function __construct(int $x = 0, int $y = 0, int $z = 0)
		{
			parent::__construct($x, $y);

			$this->z = $z;
		}

		public function __toString(): string
		{
			return $this->x . "," . $this->y . "," . $this->z;
		}
	}
?>
