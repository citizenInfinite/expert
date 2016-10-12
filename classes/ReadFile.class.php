<?php 

class  Engine {
 	private $_fileName;
	private $_facts;
	private $_query;
	private $_symbols;

    function __construct($f_name)
    {
        $this->_fileName = $f_name;
		$this->_facts = array();
		$this->_symbols = array();
		$this->_facts = array();
    }
	public function runEngine() {
		$this->_readFile();
	}
    private function _readFile() {
        $name = (string)$this->_fileName;
        $fd = fopen($name, 'r');
        $all_arr = array();
        if (!$fd){
            echo "ERROR";
            return false;
        }
        while($f_arr = fgets($fd)){
            array_push($all_arr, $f_arr);
        }
        $this->_separateInput($all_arr);
    }
	private function _findSymbols($symStr) {
		$cnt = 0;
		foreach($symStr as $syms) {
			if (isAlpha($syms)) {
				$this->_symbols[$cnt++] = $syms;
			}
		}
	}
	private function _findAtecedent($rules) {
		$tmp = explode();
	}
    private function _separateInput($s_arr) {
        $comment = array();
        $rule = array();
        $fact = array();
        $queries = array();
        foreach ($s_arr as $elem) {
            $swi = $elem[0];
            switch ($swi) {
                case '=':
					$elem = preg_replace("[#.*]", "", $elem); // remove comments
                	array_push($fact, $elem);
                	break;
                case '?':
					$elem = preg_replace("[#.*]", "", $elem); // remove comments
                	array_push($queries, $elem);
                	break;
				case '\n':
				case '#':
					break;
                default:
                	if (trim($elem) !== "") {
						$elem = preg_replace("[#.*]", "", $elem); // remove comments
                    	array_push($rule, $elem);
					}
            }
        }
		$this->_findSymbols(implode(";", $rule));
		echo "rules\n";
		print_r($rule);
		echo "=======\n\nfacts\n";
		print_r($fact);
		echo "=======\nqueries\n";
		print_r($queries);
    }
	
}

?>
