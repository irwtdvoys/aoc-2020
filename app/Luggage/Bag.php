<?php
	namespace App\Luggage;

	use Bolt\Base;

	class Bag extends Base
	{
		public string $name = "";
		public array $children = [];

		public function contains()
		{
			$bags = [$this->name];

			if (count($this->children) > 0)
			{
				foreach ($this->children as $child)
				{
					$bags = array_merge($bags, $child['bag']->contains());
				}
			}

			return array_unique($bags);
		}

		public function count()
		{
			$count = 1;

			if (count($this->children) > 0)
			{
				foreach ($this->children as $child)
				{
					echo($child['bag']->name . " x" . $child['quantity'] . PHP_EOL);
					$count += $child['quantity'] * $child['bag']->count();
				}
			}

			return $count;
		}
	}
?>
