<?php
class Backup{
    
    private $path;
    private $dataBase;
    private $userName;
    private $password;
    private $arrayTable;
    /*
     * Konstruktor podanie scieżki w której będą zapisywane backupy, nazwy bazy, oraz użytkownika i hasła do bazy
     * autopatycznie przypisuje do obiektu wszytkie tabele w bazie
     */
    public function __construct($path, $dataBase, $userName, $password){
        $this->path = $path;
        $this->dataBase = $dataBase;
        $this->userName = $userName;
        $this->password = $password;
        $this->arrayTable = array("users", "ranks", "page_settings", "articles", "galleries", "privilages",
            "templates", "tasks", "maps", "calendaries", "form", "comments", "ingallery",
            "photo", "predefinied_areas", "maps_coords", "event", "fields");
    }
    
    public function toString(){
        return 'path= '.$this->path.' database= '.$this->dataBase.' username= '.$this->userName;
    }

    /*
     * Metoda zwraca string który należy wprowadzić do zapytania mysqli
     * zapytanie stowrzy event backup który co nterwał będzie tworzył backup
     * jezeli nie wprowadzimy listy tabel automatycznie przeprowadzi backup wszystkich
     */
    public function createEventBackup($interval, $arrayTable = null){
        if($arrayTable == null){
            $arrayTable = $this->arrayTable;
        }
        $query = '
        CREATE EVENT backup
        ON SCHEDULE EVERY '.$interval.'
        STARTS '.date('y-m-01 00:00:00').' 
        DO
        BEGIN
        ';
        for($i = 0; $i < count($arrayTable); $i++){
            $query = $query.'SELECT * INTO OUTFILE '.$this->path.date('y_m_d').'/'.$arrayTable[$i].'.sql FROM '.$this->dataBase.'.'.$arrayTable[$i].'; ';
        }   
        $query = $query.'
            END';
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
     * Metoda robiąca backup na rządanie,
     * zwraca true jeżeli backup się powiódł
     * zwraca false jeżeli backup się nie udał
     */
    public function doBackup(){
        $filename = $this->path.date('y_m_d').'/database_backup.sql';
        $exec = 'mysqldump '.$this->dataBase.' --password='.$this->password.' --user='.$this->userName .' --single-transaction >'.$filename;
        echo $exec;
        //$result = exec($exec, $output);
        if($output==''){
            return true;
        }
        else {
            return false;
        }
    }
    /*
     * Metoda odzyskująca baze dancyh
     * zwraca string który jest zapytaniem sql
     */
    public function recover($date){
        $query = "";
        if($handle = opendir($this->path.$date)){
            while (false !== ($file = readdir($handle))){
		if ($file != "." && $file != ".."){
                    $query = $query.fread(fopen($file, "r"), filesize($file));
		}
            }
            closedir($handle);
	}
        return $query;
    }
    
    public function recoverDatabase($date){
        $exec ='mysql '.$this->dataBase.' -u '.$this->userName .' -p < '.$this->path.$date.'/database_backup.sql';
        echo $exec;
        //$result = exec($exec, $output);
        if($output==''){
            /* no output is good */
        }
        else {
            /* we have something to log the output here*/
        }
        
    }
}

$test = new Backup("/folder/folder/", "baza_ds", "userName", "Pass");
echo $test->toString();
echo "<br>";
echo $test->createEventBackup("10 WEEK", array("users", "ranks"));
echo "<br>";
echo $test->createEventBackup("10 WEEK");
echo "<br>";
echo $test->alterEventBackup("1 MONTH");
echo "<br>";
echo $test->doBackup();
echo "<br>";
echo $test->recover("14-12-01");
echo "<br>";
echo $test->recoverDatabase("14-12-01");