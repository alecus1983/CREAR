<?

requiere_once('config.php');

class imcrea {

    protected $_db;

    public function __construct(){

        $this->_db=new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

        if($this->_$db->connect_errno) {
            echo "fallo al conectar bd".$this->_db->connect_errno;
            return;
        }

        $this->_db->set_charset(DB_CHARSET);
    }
}
?>
