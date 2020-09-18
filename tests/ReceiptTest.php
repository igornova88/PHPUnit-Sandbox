<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase {
	public function setUp(): void {
		$this->Receipt = new Receipt();
	}

	public function tearDown(): void {
		unset($this->Receipt);
	}

	public function testTotal() {
		$input = [0,2,5,8];
		$coupon = null;				# coupon ima vrednost null i nije mi bitan za test
		$output = $this->Receipt->total($input, $coupon);
		$this->assertEquals(
			15,
			$output,
			'When summing the total should equal 15'
		);
	}

	public function testTax() {
		$inputAmount = 10.00;
		$taxInput = 0.10;
		$output = $this->Receipt->tax($inputAmount, $taxInput);
		$this->assertEquals(
			1.00,
			$output,
			'The tax calculation should equal 1.00'
		);
	}

	public function testTotalAndCoupon() {
		$input = [0,2,5,8];
		$coupon = 0.20;				# ovde ima efekat na test, pa zato ima i vrednost
		$output = $this->Receipt->total($input, $coupon);
		$this->assertEquals(
			12,
			$output,
			'When summing the total should equal 12'
		);
	}
	
	// this test and next test work same thing
	// but this one is Stub
	// next one is Mock
	public function testPostTaxTotalStub() {
		$Receipt = $this->getMockBuilder('TDD\Receipt')
			->setMethods(['tax', 'total'])
			->getMock();
		$Receipt->method('total')
			->will($this->returnValue(10.00));
		$Receipt->method('tax')
			->will($this->returnValue(1.00));
		$result = $Receipt->postTaxTotal([1,2,5,8], 0.20, null);
		$this->assertEquals(11.00, $result);
	}

	public function testPostTaxTotalMock() {
		$items = [1,2,5,8];
		$tax = 0.20;
		$coupon = null;
		$Receipt = $this->getMockBuilder('TDD\Receipt')
			->setMethods(['tax', 'total'])
			->getMock();
		$Receipt->expects($this->once())
			->method('total')
			->with($items, $coupon)
			->will($this->returnValue(10.00));
		$Receipt->expects($this->once())
			->method('tax')
			->with(10.00, $tax)
			->will($this->returnValue(1.00));
		$result = $Receipt->postTaxTotal([1,2,5,8], 0.20, null);
		$this->assertEquals(11.00, $result);
	}
	
	/**
	 * @dataProvider provideTotal
	 */
	public function testTotalWithDataProvider($items, $expected) {
		$coupon = null;
		$output = $this->Receipt->total($items, $coupon);
		$this->assertEquals(
			$expected,
			$output,
			"When summing the total should equal {$expected}"
		);
	}
	
	public function provideTotal() {
		return [
			[[1,2,5,8], 16],
			[[-1,2,5,8], 14],
			[[1,2,8], 11],
		];
	}
	
	public function provideTotalWithAssocNames() {
		return [
			'ints totaling 16' => [[1,2,5,8], 16],
			'ints totaling 14' => [[-1,2,5,8], 14],
			'ints totaling 11' => [[1,2,8], 11],
		];
	}

	public function testTotalException() {
        $input = [0,2,5,8];
        $coupon = 1.20;
        $this->expectException('BadMethodCallException');
        $this->Receipt->total($input, $coupon);
    }    

	/**
	 * @dataProvider provideCurrencyAmt
	 */
	public function testCurrencyAmt($input, $expected, $msg) {
		$this->assertSame(
			$expected,
			$this->Receipt->currencyAmt($input),
			$msg
		);
	}

	public function provideCurrencyAmt() {
		return [
			[1, 1.00, '1 should be transformed into 1.00'],
			[1.1, 1.10, '1.1 should be transformed into 1.10'],
			[1.11, 1.11, '1.11 should stay as 1.11'],
			[1.111, 1.11, '1.111 should be transformed into 1.11'],
		];
	}
}