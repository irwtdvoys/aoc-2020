<?php
	namespace App\VirtualMachine;

	use Bolt\Base;

	/**
	 * Class Instruction
	 * @package App\VirtualMachine
	 * @method operation(?string $data = null)
	 * @method argument(?int $data = null)
	 */
	class Instruction extends Base
	{
		const ACCUMULATOR = "acc";
		const JUMPS = "jmp";
		const NO_OPERATION = "nop";

		public string $operation = "";
		public int $argument = 0;

		public function __construct(string $operation, int $argument)
		{
			parent::__construct([
				"operation" => $operation,
				"argument" => $argument
			]);
		}

		public function __toString()
		{
			return $this->operation() . " " . (($this->argument() < 0) ? "-" : "+") . abs($this->argument());
		}
	}
?>
