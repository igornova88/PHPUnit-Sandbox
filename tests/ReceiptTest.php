<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase {
    public function testTotal() {
        $Receipt = new Receipt();
        $this->assertEquals(
            14,                                         // expected value
            $Receipt->total([0,2,5,8]),                 // what we are testing
            'When summing the total should equal 15'    // message displayed in case of failure
        );
    }
}
