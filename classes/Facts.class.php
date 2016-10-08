<?php
	class Fact {
		private $_symbol;
		private $_value;

		public function __construct($s, $v) {
			$this->_symbol = $s;
			$this->_value = $v;
		}
		public function changeValue($new_value) {
			$this->_value = $new_value;
		}
	}
?>
