<?php
	namespace App\PasswordPolicy;

	class Password
	{
		public int $min;
		public int $max;

		public string $value;
		public string $password;

		public function __construct(string $data)
		{
			preg_match("/^(?'min'[0-9]+)-(?'max'[0-9]+) (?'value'[a-z]): (?'password'[a-z]+)$/", $data, $matches);

			$this->min = (int)$matches['min'];
			$this->max = (int)$matches['max'];

			$this->value = $matches['value'];
			$this->password = $matches['password'];
		}

		public function getPasswordCharacter(int $value)
		{
			return $this->password[$value - 1];
		}

		public function isValidSled()
		{
			$count = substr_count($this->password, $this->value);

			return $count >= $this->min && $count <= $this->max;
		}

		public function isValidToboggan()
		{
			$target = $this->getPasswordCharacter($this->min) . $this->getPasswordCharacter($this->max);

			return substr_count($target, $this->value) === 1;
		}
	}
?>
