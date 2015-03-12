<?php

class StringToArrayConverter
{
	const FIRST_LINE_AS_LABELS_FLAG = '#useFirstLineAsLabels';

	public function convert($string)
	{
		$this->validate($string);

		$lines = $this->getLines($string);

		if (count($lines) === 1)
		{
			return $this->convertSingleLine($string);
		}

		return $this->hasLabels($lines)
			? $this->convertMultiLineWithLabels($lines)
			: $this->convertMultiLine($lines);
	}

	protected function convertSingleLine($line)
	{
		return explode(',', $line);
	}

	protected function convertMultiLine(array $lines)
	{
		return array_map(
			function($line) { return $this->convertSingleLine($line); },
			$lines
		);
	}

	public function convertMultiLineWithLabels(array $lines)
	{
		$labels = $this->getLabels($lines);

		$this->removeLabels($lines);

		return array(
			'labels' => $labels,
			'data'   => $this->convertMultiLine($lines)
		);
	}

	protected function validate($string)
	{
		if (empty($string) || !is_string($string))
		{
			throw new InvalidArgumentException();
		}
	}

	protected function hasLabels(array $lines)
	{
		return self::FIRST_LINE_AS_LABELS_FLAG === $lines[0];
	}

	protected function getLabels(array $lines)
	{
		return $this->convertSingleLine($lines[1]);
	}

	protected function removeLabels(array &$lines)
	{
		unset($lines[0], $lines[1]);

		// Reorder keys.
		$lines = array_values($lines);
	}

	protected function getLines($string)
	{
		return explode("\n", $string);
	}
}
