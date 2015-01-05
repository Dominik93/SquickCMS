<?php
include "Controller.php";
class Backup{
    
    private $path;
    private $dataBase;
    private $userName;
    private $password;
    private $tables;
    private $views;
    /*
     * Konstruktor podanie scieżki w której będą zapisywane backupy, nazwy bazy, oraz użytkownika i hasła do bazy
     * autopatycznie przypisuje do obiektu wszytkie tabele w bazie
     */
    public function __construct($path, $dataBase, $userName, $password){
        $this->path = $path;
        $this->dataBase = $dataBase;
        $this->userName = $userName;
        $this->password = $password;
        $this->tables = array("sessions", "news", "publisher_houses", "authors", "books", "authors_books", "acces_rights", "admins", "readers", "borrows");
        $this->views = array("fees", "free_books");
    }
    
    public function toString(){
        return 'path= '.$this->path.' database= '.$this->dataBase.' username= '.$this->userName;
    }
    
    /*
     * jeżeli to cholerstwo myslqdump nie będzie działac to tu jest coś zamiast tego
     * returnuje string ktory trzeba zapisać do pliku
     */
    public function dump(){
        $con = mysqli_connect ( "localhost", $this->userName, $this->password, $this->dataBase );
        /*
        $tables = array();
        $views = array();
        $result = mysqli_query ( $con, 'SHOW FULL TABLES' ) or die(mysqli_error($con));
        while ( $row = mysqli_fetch_array ( $result ) ) {
            if($row[1] == "VIEW")
                $views [] = $row [0];
            else
                $tables [] = $row [0];
        }*/
        // cycle through the tables
        foreach ( $this->tables as $table ) {
            $result = mysqli_query ( $con, "SELECT * FROM `$table`");
            $num_fields = mysqli_num_fields ( $result );
            $num_rows = mysqli_num_rows( $result );
            $return .= "--\n-- Structure for the table $table\n--\n\n";
            $return .= "DROP TABLE IF EXISTS `$table`;";
            $row2 = mysqli_fetch_array ( mysqli_query ( $con, "SHOW CREATE TABLE `$table`" ) );
            $return .= "\n\n" . $row2 [1] . ";\n\n";
            if ($num_rows > 0) {
                $return .= "--\n-- Data dump for the table $table\n--\n\n";
            }
            
            $i = 0;
            while ( $row = mysqli_fetch_array ( $result ) ) {
                if ($i == 0) {
                    $return .= "INSERT INTO `$table` VALUES\n";
                }
                $i++;
                for($j = 0; $j < $num_fields; $j ++) {
                    if ($j == 0) {
                        $return .= '(';
                    }
                    $row [$j] = addslashes ( $row [$j] );
                    $row [$j] = mysqli_real_escape_string ( $con, $row [$j] );
                    if (isset ( $row [$j] )) {
                        $return .= '"' . $row [$j] . '"';
                    } 
                    else {
                        $return .= '""';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }
                if ($i < $num_rows) { 
                    $return .= "),\n"; 
                } 
                else { 
                    $return .= ");\n\n"; 
                }
            }
        }
        foreach ( $this->views as $view ) {
            $result = mysqli_query ( $con, "SELECT * FROM `$view`");
            $num_fields = mysqli_num_fields ( $result );
            $num_rows = mysqli_num_rows( $result );
            $return .= "--\n-- Structure for the table $view\n--\n\n";
            $return .= "DROP TABLE IF EXISTS `$view`;";
            $row2 = mysqli_fetch_array ( mysqli_query ( $con, "SHOW CREATE TABLE `$view`" ) );
            $return .= "\n\n" . $row2 [1] . ";\n\n";
        }
        $file = $this->path.'backup_'.date("Y_m_d").'.sql';
        $fp = fopen($file, "a");
        flock($fp, 2);
        fwrite($fp, $return);
        flock($fp, 3);
        fclose($fp); 
        return $return; 
    }
    
    public function recoverDataBase($date){
        $query = "";
        $query = $query.fread(fopen($this->path.'backup_'.$date.'.sql', "r"), filesize($this->path.'backup_'.$date.'.sql'));
        return $query;
    }
}

