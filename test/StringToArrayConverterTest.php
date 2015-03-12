<?php

require __DIR__ . '/../src/StringToArrayConverter.php';

class StringToArrayConverterTest extends PHPUnit_Framework_TestCase
{
	const SINGLE_LINE_STRING_WITHOUT_COMMA = 'This is a test line without comma';

	/**
	 * @var StringToArrayConverter
	 */
	protected $converter;

	public function setUp()
	{
		$this->converter = new StringToArrayConverter();
	}

	public function convertSingleLineDataProvider()
	{
		return array(
			array(
				'a,b,c',
				array(
					'a', 'b', 'c'
				),
			),
			array(
				'100,982,444,990,1',
				array(
					100, 982, 444, 990, 1
				),
			),
			array(
				'Mark,Anthony,marka@lib.de',
				array(
					'Mark', 'Anthony', 'marka@lib.de'
				)
			),
		);
	}

	public function convertMultiLineDataProvider()
	{
		return array(
			array(
				"211,22,35\n10,20,33",
				array(
					array(211, 22, 35),
					array(10, 20, 33),
				),
			),
			array(
				"luxembourg,kennedy,44\nbudapest,expo ter,5-7\ngyors,fo utca,9",
				array(
					array('luxembourg', 'kennedy', 44),
					array('budapest', 'expo ter', '5-7'),
					array('gyors', 'fo utca', 9),
				),
			),
		);
	}

	public function convertMultiLineWithLabelsDataProvider()
	{
		return array(
			array(
				"#useFirstLineAsLabels\nName,Email,Phone\nMark,marc@be.com,998\nNoemi,noemi@ac.co.uk,888",
				array(
					'labels' => array('Name', 'Email', 'Phone'),
					'data' => array(
						array('Mark', 'marc@be.com', 998),
						array('Noemi', 'noemi@ac.co.uk', 888),
					),
				),
			),
		);
	}

	/**
	 * @dataProvider convertSingleLineDataProvider
	 */
	public function testConvertSingleLine($line, $expected)
	{
		$resultArray = $this->converter->convert($line);

		$this->assertEquals($expected, $resultArray);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConvertWithInvalidArgument()
	{
		$this->converter->convert(new StdClass);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConvertWithEmptyArgument()
	{
		$this->converter->convert('');
	}

	public function testConvertSingeLineWithoutComma()
	{
		$resultArray = $this->converter->convert(self::SINGLE_LINE_STRING_WITHOUT_COMMA);

		$this->assertEquals(array(self::SINGLE_LINE_STRING_WITHOUT_COMMA), $resultArray);
	}

	/**
	 * @dataProvider convertMultiLineDataProvider
	 */
	public function testConvertMultiLine($multiLine, $expected)
	{
		$resultArray = $this->converter->convert($multiLine);

		$this->assertEquals($expected, $resultArray);
	}

	/**
	 * @dataProvider convertMultiLineWithLabelsDataProvider
	 */
	public function testConvertMultiLineWithLabels($multiLine, $expected)
	{
		$resultArray = $this->converter->convert($multiLine);

		var_export($resultArray);

		$this->assertEquals($expected, $resultArray);
	}
}
