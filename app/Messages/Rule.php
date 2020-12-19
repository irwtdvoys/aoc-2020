<?php
	namespace App\Messages;

	class Rule
	{
		public array $options = [];
		public ?string $generated = null;

		public function __construct(string $data)
		{
			$this->options = array_map(
				function ($element)
				{
					return explode(" ", $element);
				},
				explode(" | ", $data)
			);
		}
	}
?>
