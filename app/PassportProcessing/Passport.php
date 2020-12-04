<?php
	namespace App\PassportProcessing;

	use Bolt\Base;

	class Passport extends Base
	{
		public string $ecl;
		public string $pid;
		public int $eyr;
		public string $hcl;
		public int $byr;
		public int $iyr;
		public string $cid;
		public string $hgt;

		public function __construct($data)
		{
			$parameters = explode(" ", implode(" ", explode(PHP_EOL, $data)));

			foreach ($parameters as $parameter)
			{
				list($field, $value) = explode(":", $parameter);
				$this->$field($value);
			}
		}

		public function isValid(bool $detailed = false): bool
		{
			$properties = $this->getProperties();

			foreach ($properties as $property)
			{
				if ($property === "cid")
				{
					continue;
				}

				if (!isset($this->$property))
				{
					return false;
				}

				if ($detailed === true)
				{
					$value = $this->$property;

					switch ($property)
					{
						case "byr":
							if ($value < 1920 || $value > 2002)
							{
								return false;
							}
							break;
						case "iyr":
							if ($value < 2010 || $value > 2020)
							{
								return false;
							}
							break;
						case "eyr":
							if ($value < 2020 || $value > 2030)
							{
								return false;
							}
							break;
						case "hgt":

							if (substr($value, -2 ) === "cm")
							{
								if ($value < 150 || $value > 193)
								{
									return false;
								}
							}
							elseif (substr($value, -2 ) === "in")
							{
								if ($value < 59 || $value > 76)
								{
									return false;
								}
							}
							else
							{
								return false;
							}

							break;
						case "hcl":
							if (preg_match('/^#[0-9a-f]{6}$/', $value) === 0)
							{
								return false;
							}
							break;
						case "ecl":
							if (!in_array($value, ["amb", "blu", "brn", "gry", "grn", "hzl", "oth"]))
							{
								return false;
							}
							break;
						case "pid":
							if (preg_match('/^[0-9]{9}$/', $value) === 0)
							{
								return false;
							}
							break;
					}
				}
			}

			return true;
		}
	}
?>
