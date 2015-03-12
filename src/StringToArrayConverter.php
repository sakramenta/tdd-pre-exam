<?php

class StringToArrayConverter
{
	public function convertLine($line)
	{
		if (empty($line) || !is_string($line))
		{
			throw new InvalidArgumentException();
		}

		return explode(',', $line);
	}
}
