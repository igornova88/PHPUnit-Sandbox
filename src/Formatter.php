<?php
namespace TDD;
use \BadMethodCallException; 

class Formatter {
	public function currencyAmt($input) {
		return round($input, 2);
	}
}