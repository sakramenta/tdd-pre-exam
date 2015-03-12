<?php

class StringToArrayConverter
{
	public function convertLine($string)
	{
		$this->validate($string);

		return explode(',', $string);
	}

	public function convertMultiLine($string)
	{
		$this->validate($string);

		$lines = explode("\n", $string);

		return array_map(
			function($line) { return $this->convertLine($line); },
			$lines
		);
	}

	protected function validate($string)
	{
		if (empty($string) || !is_string($string))
		{
			throw new InvalidArgumentException();
		}
	}
}
