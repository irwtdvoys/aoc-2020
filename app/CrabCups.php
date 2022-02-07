<?php
	namespace App;

	use AoC\Helper;
	use AoC\Result;
	use App\CrabCombat\Combat;
	use App\CrabCombat\Deck;
	use App\CrabCombat\RecursiveCombat;
	use AoC\Utils\CircularLinkedList;
	use AoC\Utils\LinkedList;
	use AoC\Utils\Range;

	class CrabCups extends Helper
	{
		public CircularLinkedList $cups;
		public LinkedList $picked;

		public Range $range;
		public array $index = [];

		public ?string $override = null;

		public function __construct(int $day, bool $verbose = false, string $override = null)
		{
			parent::__construct($day, $verbose);

			$this->override = $override;
		}

		public function initialise(bool $extended = false): void
		{
			$this->cups = new CircularLinkedList();
			$this->picked = new LinkedList();

			$values = str_split(parent::load($this->override));

			foreach ($values as $element)
			{
				$this->cups->push($element);
				$this->index[$element] = $this->cups->current->previous;
			}

			if ($extended === true)
			{
				for ($loop = count($this->cups); $loop < 1000000; $loop++)
				{
					$value = $loop + 1;
					$this->cups->push($value);
					$this->index[$value] = $this->cups->current->previous;
				}
			}

			$values = array_keys($this->index);

			$this->range = new Range(min($values), max($values));
		}

		public function pickupCups(): void
		{
			$this->picked->first = $this->cups->current->next;
			$this->picked->last = $this->cups->current->next->next->next;

			$this->cups->current->next = $this->picked->last->next;
			$this->cups->current->next->previous = $this->cups->current;

			$this->picked->first->previous = null;
			$this->picked->last->next = null;
			$this->picked->reset();
			$this->picked->count = 3;
		}

		public function isPickedUp(int $value): bool
		{
			foreach ($this->picked as $next)
			{
				if ($next->data === $value)
				{
					return true;
				}
			}

			return false;
		}

		public function move(): void
		{
			$this->pickupCups();

			$pickedUp = true;
			$destination = $this->cups->current->data - 1;
			$destination = ($destination < $this->range->min) ? $this->range->max : $destination;

			while ($pickedUp === true)
			{
				$pickedUp = $this->isPickedUp($destination);

				if ($pickedUp === true)
				{
					$destination = ($destination <= $this->range->min) ? $this->range->max : $destination - 1;
				}
			}

			$pointer = $this->index[$destination];

			$this->picked->first->previous = $pointer;
			$this->picked->last->next = $pointer->next;
			$pointer->next->previous = $this->picked->last;
			$pointer->next = $this->picked->first;

			$this->cups->next();
		}

		public function play(int $moves): void
		{
			$move = 1;

			while ($move <= $moves)
			{
				$this->move();

				$move++;
			}
		}

		public function run(): Result
		{
			$result = new Result(0, 0);

			$this->initialise();
			$this->play(100);
			$result->part1 = implode("", $this->cups->data($this->index[1]->next, 8));

			$this->initialise(true);
			$this->play(10000000);

			list($one, $two) = $this->cups->data($this->index[1]->next, 2);

			$result->part2 = $one * $two;

			return $result;
		}
	}
?>
