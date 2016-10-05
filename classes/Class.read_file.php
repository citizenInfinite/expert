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
                case '#':
                array_push($comment, $elem);
                break;
                case '=':
                array_push($fact, $elem);
                break;
                case '?':
                array_push($queries, $elem);
                break;
                default:
                if (trim($elem) !== "")
                    array_push($rule, $elem);
            }
        }
        echo "comments\n";
            print_r($comment);
            echo "rules\n";
            print_r($rule);
            echo "facts\n";
            print_r($fact);
            echo "queries\n";
            print_r($queries);
    }
}

?>
