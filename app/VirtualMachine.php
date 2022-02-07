<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\Luggage\Bag;
	use App\VirtualMachine\Instruction;
	use Bolt\Base;
	use Exception;

	/**
	 * Class VirtualMachine
	 * @package App
	 * @method instructions(?array $instructions)
	 */
	class VirtualMachine extends Base
	{
		const TERMINATED = 0;
		const LOOP_DETECTED = 1;

		public array $instructions;
		public int $pointer;
		public array $history;
		public int $accumulator;

		public function __construct($data = null)
		{
			parent::__construct($data);

			$this->reset();
		}

		public function __clone(): void
		{
			$this->instructions = array_map(
				function($element)
				{
					return clone $element;
				},
				$this->instructions
			);
		}

		public function reset(): void
		{
			$this->pointer = 0;
			$this->history = array();
			$this->accumulator = 0;
		}

		private function processNextInstruction(): void
		{
			if ($this->alreadyExecuted())
			{
				throw new Exception("Loop detected", self::LOOP_DETECTED);
			}

			if ($this->pointer >= count($this->instructions))
			{
				throw new Exception("Terminated", self::TERMINATED);
			}

			$instruction = $this->instructions[$this->pointer];

			$this->history[] = $this->pointer;

			switch ($instruction->operation)
			{
				case Instruction::ACCUMULATOR:
					$this->accumulator += $instruction->argument;
					$this->pointer++;
					break;
				case Instruction::JUMPS:
					$this->pointer += $instruction->argument;
					break;
				case Instruction::NO_OPERATION:
				default:
					$this->pointer++;
					break;
			}
		}

		public function alreadyExecuted(): bool
		{
			return in_array($this->pointer, $this->history);
		}

		public function process(): int
		{
			while (true)
			{
				try
				{
					$this->processNextInstruction();
				}
				catch (Exception $exception)
				{
					return $exception->getCode();
				}
			}
		}
	}
?>
