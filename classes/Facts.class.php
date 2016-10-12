<?php
	class Fact {
		private $_symbol;
		private $_value;
		private $_antecedent;
		private $_ruleCnt;

		private function _evalRule() {
			// eval algorithm
		}
		public function __construct($s) {
			$this->_symbol = $s;
			$this->_value = false;
		}
		public function changeValue($new_value) {
			$this->_value = $new_value;
		}
		public function setAntecedent($rule) {
			$this->_antecedent[$this->_ruleCnt++] = $rule;
		}
		public function getValue() {
			return $this->_value;
		}
		public function getAtecedent() {
			return $this->_antecedent;
		}
		public function getSymbol() {
			return $this->_symbol;
		}
	}
?>
