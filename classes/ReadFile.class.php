<?php 

class ReadFile 
{
   public $_fileName;

    function __construct($f_name)
    {
        $this->_fileName = $f_name;
    }
    public function read_file() {
        $name = (string)$this->_fileName;
        $fd = fopen($name, 'r');
        if (!$fd){
            echo "ERROR";
            return false;
        }
        $all_arr = array();
        while($f_arr = fgets($fd)){
            array_push($all_arr, $f_arr);
        }
        return $all_arr;
    }
    public function _SeparateInput($s_arr) {
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
		echo "rules\n";
		print_r($rule);
		echo "=======\n\nfacts\n";
		print_r($fact);
		echo "=======\nqueries\n";
		print_r($queries);
    }
}

?>
