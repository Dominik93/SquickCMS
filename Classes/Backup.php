<?php
include "../config.php";

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
        $this->tables = array("acces_rights", "admins", "authors",
            "authors_books", "books", "borrows", "logs_readers",
            "news", "publisher_houses", "readers", "sessions");
        $this->views = array();
    }
    
    /*
     * jeżeli to cholerstwo myslqdump nie będzie działac to tu jest coś zamiast tego
     * zapisuje to do pliku cała strukture tabeli wraz z wartościami w nich
     */
    public function dump(){
        $con = mysqli_connect ( "localhost", $this->userName, $this->password, $this->dataBase );
        foreach ( $this->tables as $table ) {
            $result = mysqli_query ( $con, "SELECT * FROM `$table`");
            $num_fields = mysqli_num_fields ( $con, $result );
            $num_rows = mysqli_num_rows( $con, $result );
            $return .= "--\n-- Structure for the table $table\n--\n\n";
            $return .= "DROP TABLE IF EXISTS `$table`;";
            $row2 = mysqli_fetch_array ( $con, mysqli_query ( $con, "SHOW CREATE TABLE `$table`" ) );
            $return .= "\n\n" . $row2 [1] . ";\n\n";
            if ($num_rows > 0) {
                $return .= "--\n-- Data dump for the table $table\n--\n\n";
            }
            
            $i = 0;
            while ( $row = mysqli_fetch_array ( $con, $result ) ) {
                if ($i == 0) {
                    $return .= "INSERT INTO `$table` VALUES\n";
                }
                $i++;
                for($j = 0; $j < $num_fields; $j ++) {
                    if ($j == 0) {
                        $return .= '(';
                    }
                    $row [$j] = addslashes (  $row [$j] );
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
            $num_fields = mysqli_num_fields ( $con, $result );
            $num_rows = mysqli_num_rows($con, $result );
            $return .= "--\n-- Structure for the table $view\n--\n\n";
            $return .= "DROP TABLE IF EXISTS `$view`;";
            $row2 = mysqli_fetch_array ( $con, mysqli_query ( $con, "SHOW CREATE TABLE `$view`" ) );
            $return .= "\n\n" . $row2 [1] . ";\n\n";
        }
        mysqli_close($con);
        $file = $this->path.'backup_'.date("Y_m_d").'.sql';
        $fp = fopen($file, "a");
        flock($fp, 2);
        fwrite($fp, $return);
        flock($fp, 3);
        fclose($fp); 
        return $return; 
    }
    /*
     * metoda wczytująca backup stworzony metodą dump
     */
    public function recoverDataBase($date){
        $query = fread(fopen($this->path.'backup_'.$date.'.sql', "r"), filesize($this->path.'backup_'.$date.'.sql'));
        $con = mysqli_connect ( "localhost", $this->userName, $this->password, $this->dataBase );
        mysqli_query($con, $query) or die(mysqli_error($con));
        mysqli_close($con);
    }
}

$backup = new Backup(backToFuture().'Library/Backup', "dslusarz-baza", "dslusarz", "kasztan");
echo $backup->dump();