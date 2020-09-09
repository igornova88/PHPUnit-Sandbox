<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase {
    # create instance that we need
    # from PHP7 we need return type :void
	public function setUp(): void {
		$this->Receipt = new Receipt();
	}

    # remove instance at the end of the test
    # this allows testing in isolation (instances are not passed to other tests)
    # from PHP7 we need return type :void
	public function tearDown(): void {
		unset($this->Receipt);
	}
	public function testTotal() {
		$input = [0,2,5,8];
		$output = $this->Receipt->total($input);
		$this->assertEquals(
			15,
			$output,
			'When summing the total should equal 15'
		);
	}
}