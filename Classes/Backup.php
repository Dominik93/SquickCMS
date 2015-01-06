<?php
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
        $this->tables = array("acces_rights", "admins", "authors", "authors_books", "books", "borrows", "logs_readers", "news", "publisher_houses", "readers", "sessions");
        $this->views = array();
    }
    public function toString(){
        return 'path= '.$this->path.' database= '.$this->dataBase.' username= '.$this->userName;
    }
    /*
     * Metoda zwraca string który należy wprowadzić do zapytania mysqli
     * zapytanie stowrzy event backup który co interwał będzie tworzył backup
     * jezeli nie wprowadzimy listy tabel automatycznie przeprowadzi backup wszystkich
     */
    public function createEventBackup($interval = "1 MONTH", $arrayTable = null){
        if($arrayTable == null){
            $arrayTable = $this->arrayTable;
        }
        $query = '
        CREATE EVENT IF NOT EXISTS backup
        ON SCHEDULE EVERY '.$interval.'
        STARTS '.date('"y-m-01 00:00:00"').' 
        DO
        BEGIN ';
        for($i = 0; $i < count($arrayTable); $i++){
            $query = $query.'SELECT * INTO OUTFILE "'.$this->path.$arrayTable[$i].'.sql" FROM '.$this->dataBase.'.'.$arrayTable[$i].'; ';
        }   
        $query = $query.'END';
        return $query;
    }
    /*
     * Metoda zwraca string który należy wprowadzić do zapytania mysqli
     * zapytanie zmieni interwał w zdarzeniu backup na podany jako argument
     */
    public function alterEventBackup($interval){
        $query = 'ALTER EVENT backup ON SCHEDULE EVERY '.$interval.';';
        return $query;
    }
    /*
     * Metoda odzyskująca baze dancyh
     * zwraca string który jest zapytaniem sql
     */
    public function recoverLast(){
        $query = "";
        if($handle = opendir($this->path)){
            while (false !== ($file = readdir($handle))){
		if ($file != "." && $file != ".."){
                    $query = $query.fread(fopen($file, "r"), filesize($file));
		}
            }
            closedir($handle);
	}
        return $query;
    }
    /*
     * Metoda robiąca backup na rządanie,
     * zwraca true jeżeli backup się powiódł
     * zwraca false jeżeli backup się nie udał
     */
    public function doBackup(){
        $filename = $this->path.'database_backup.sql';
        $exec = 'mysqldump --user='.$this->userName .' --password=\''.$this->password.'\' --host=localhost '.$this->dataBase.' >'.$filename.';';
        echo $exec;
        $result = exec($exec, $output);
        if($output==''){
            return true;
        }
        else{
            return false;
        }
    }
    /*
     * medota recoverująca baze z poleceania mysqldump
     */
    public function recoverDatabase($date){
        $exec ='mysql --host='.$this->dataBase.' -u '.$this->userName .' -p < '.$this->path.$date.'/database_backup.sql';
        echo $exec;
        //$result = exec($exec, $output);
        if($output==''){
            return true;/* no output is good */
        }
        else{
            return false;/* we have something to log the output here*/
        }
        
    }
    /*
     * jeżeli to cholerstwo myslqdump nie będzie działac to tu jest coś zamiast tego
     * zapisuje to do pliku cała strukture tabeli wraz z wartościami w nich
     */
    public function dump(){
        $con = mysqli_connect ( "localhost", $this->userName, $this->password, $this->dataBase );
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

