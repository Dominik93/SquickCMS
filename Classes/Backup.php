<?php
class Backup{
    
    private $path;
    private $dataBase;
    private $arrayTable;
    
    public function __constuct($path, $dataBase){
        $this->path = $path;
        $this->dataBase = $dataBase;
        $this->arrayTable = array("users", "ranks", "page_settings", "articles", "galleries", "privilages",
            "templates", "tasks", "maps", "calendaries", "form", "comments", "ingallery",
            "photo", "predefinied_areas", "maps_coords", "event", "fields");
    }
    
    public function createEvent($interval, $arrayTable = null){
        if($arrayTable == null){
            $arrayTable = $this->arrayTable;
        }
        $query = 'DELIMITER //
        CREATE EVENT backup
        ON SCHEDULE EVERY '.$interval.'
        STARTS '.date('y-m-d h:i:s').' 
        DO
        BEGIN
        ';
        for($i = 0; $i < count($arrayTable); $i++){
            $query = $query.'SELECT * INTO OUTFILE '.$this->path.'/'.$arrayTable[$i].'.sql
                    FROM '.$this->dataBase.'.'.$arrayTable[$i].';';
        }   
        $query = $query.'
            END//
        DELIMITER';
        return $query;
    }
    
    public function alterEvent($interval){
        $query = 'ALTER EVENT backup ON SCHEDULE EVERY '.$interval.';';
        return $query;
    }
    
    public function doBackup(){
        $filename = $this->path.'/database_backup_'.date('y_m_d').'.sql';
        $result = exec('mysqldump database_name --password=your_pass --user=root --single-transaction >/var/backups/'.$filename, $output);
        if($output==''){/* no output is good */}
        else {/* we have something to log the output here*/}
    }
    
}