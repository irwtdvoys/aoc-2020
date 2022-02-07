<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\VirtualMachine\Instruction;

	class Handheld extends Helper
	{
		public VirtualMachine $vm;
		/** @var Instruction[] */
		public array $instructions = [];

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$this->vm = new VirtualMachine();
			$this->loadInstructions($override);
		}

		public function loadInstructions($override = null): void
		{
			$this->instructions = array_map(
				function($element)
				{
					list($operation, $argument) = explode(" ", $element);

					return new Instruction($operation, (int)$argument);
				},
				explode(PHP_EOL, parent::load($override))
			);

			$this->vm->instructions($this->instructions);
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$original = clone $this->vm;

			$this->vm->process();
			$result->part1 = $this->vm->accumulator;

			for ($index = 0; $index < count($original->instructions); $index++)
			{
				$this->vm = clone $original;

				$instruction = $this->vm->instructions[$index];

				if ($instruction->operation === Instruction::ACCUMULATOR)
				{
					continue;
				}

				// alter $instruction
				switch ($instruction->operation)
				{
					case Instruction::JUMPS:
						$this->vm->instructions[$index]->operation = Instruction::NO_OPERATION;
						break;
					case Instruction::NO_OPERATION:
						$this->vm->instructions[$index]->operation = Instruction::JUMPS;
						break;
				}

				// process
				$output = $this->vm->process();

				if ($output === VirtualMachine::TERMINATED)
				{
					$result->part2 = $this->vm->accumulator;
				}
			}

			return $result;
		}
	}
?>
