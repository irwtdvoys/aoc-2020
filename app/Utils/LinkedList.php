<?php
	namespace App\Utils;

	use App\Utils\LinkedList\Node;
	use Countable;
	use Iterator;

	class LinkedList implements Iterator, Countable
	{
		public ?Node $first = null;
		public ?Node $last = null;
		public ?Node $current = null;
		public int $count = 0;
		public int $index = 0;

		public function __construct(int $length = null)
		{
			if ($length !== null)
			{
				$this->initialise($length);
			}
		}

		public function initialise(int $length): self
		{
			for ($loop = 0; $loop < $length; $loop++)
			{
				$this->push($loop);
			}

			return $this;
		}

		public function reset(): self
		{
			$this->current = $this->first;
			$this->index = 0;

			return $this;
		}

		public function next(): void
		{
			$this->current = $this->current->next;
			$this->index++;
		}

		public function previous(): void
		{
			$this->current = $this->current->previous;
			$this->index--;
		}

		public function forward(int $steps): void
		{
			for ($loop = 0; $loop < $steps; $loop++)
			{
				$this->next();
			}
		}

		public function backward(int $steps): void
		{
			for ($loop = 0; $loop < $steps; $loop++)
			{
				$this->previous();
			}
		}

		public function insert($value): void
		{
			$before = $this->current;
			$after = $this->current->next;

			$new = new Node($value, $before, $after);

			$before->next = $new;
			$after->previous = $new;

			$this->next();

			$this->count++;
		}

		public function push($data): void
		{
			if (!isset($this->first))
			{
				$new = new Node($data);

				$this->first = $new;
				$this->first->previous = null;
				$this->first->next = null;

				$this->current = $new;
			}
			else
			{
				$new = new Node($data, $this->last, null);
				$this->last->next = $new;
			}

			$this->last = $new;

			$this->count++;
		}

		public function data(Node $pointer, int $length = null): array
		{
			if ($length === null)
			{
				$length = $this->count;
			}

			$count = 0;

			$results = array();

			while ($count < $length)
			{
				$results[] = $pointer->data;

				$pointer = $pointer->next;

				$count++;
			}

			return $results;
		}

		public function output(int $length = null): void
		{
			$pointer = $this->first;

			if ($length === null)
			{
				$length = $this->count;
			}

			$count = 0;

			$results = array();

			while ($count < $length)
			{
				$results[] = ($pointer === $this->current) ? "[" . $pointer->data . "]" : $pointer->data;

				$pointer = $pointer->next;

				$count++;
			}

			echo(implode(" ", $results) . PHP_EOL);
		}

		public function get(int $index): int
		{
			$pointer = $this->first;

			for ($loop = 0; $loop < $index; $loop++)
			{
				$pointer = $pointer->next;
			}

			return $pointer->data;
		}

		// Iterator
		public function current(): ?Node
		{
			return $this->current;
		}

		public function key(): int
		{
			return $this->index;
		}

		public function valid(): bool
		{
			return $this->index < $this->count;
		}

		public function rewind(): void
		{
			$this->reset();
		}

		// Countable
		public function count(): int
		{
			return $this->count;
		}
	}
?>
