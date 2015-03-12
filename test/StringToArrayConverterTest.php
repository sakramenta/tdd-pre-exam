<?php

require __DIR__ . '/../src/StringToArrayConverter.php';

class StringToArrayConverterTest extends PHPUnit_Framework_TestCase
{
	const TEST_LINE_WITHOUT_COMMA = 'This is a test line without comma';

	/**
	 * @var StringToArrayConverter
	 */
	protected $converter;

	public function setUp()
	{
		$this->converter = new StringToArrayConverter();
	}

	public function convertLineDataProvider()
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
					'100', '982', '444', '990', '1'
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

	/**
	 * @dataProvider convertLineDataProvider
	 */
	public function testConvertLine($line, $expected)
	{
		$resultArray = $this->converter->convertLine($line);

		$this->assertEquals($expected, $resultArray);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConvertLineWithInvalidArgument()
	{
		$this->converter->convertLine(new StdClass);
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConvertLineWithEmptyArgument()
	{
		$this->converter->convertLine('');
	}

	public function testConvertLineWithValidArgumentWithoutComma()
	{
		$resultArray = $this->converter->convertLine(self::TEST_LINE_WITHOUT_COMMA);

		$this->assertEquals(array(self::TEST_LINE_WITHOUT_COMMA), $resultArray);
	}
}
