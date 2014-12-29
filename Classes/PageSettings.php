<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageSettings
 *
 * @author Dominik
 */
class PageSettings {
    private $settings;
    private $values;
    /*
     * konstruktor klasy przyjmuje za argument wynik zapytania select * from page_settings
     */
    public function setResult($result) {
        while($row = mysqli_fetch_assoc($result)){
            array_push($this->settings, $row['setting_name']);
            array_push($this->values, $row['setting_value']);
        }
    }
    /*
     * konstruktor klasy przyjmuje za argumenty 2 listy jenda z nazwami opcji drógą z warościami
     */
    public function setArrays($arraySegings, $arrayValues) {
        $this->settings = $arraySegings;
        $this->values = $arrayValues;
    }
    
    /*
     * metoda dodająca opcje
     * zwraca string query który jest dodaje do bazy danych dodaną opcje
     */
    public function add($seting, $value){
        array_push($this->settings, $seting);
        array_push($this->values, $value);
        $query = 'INSERT INTO page_settings (setting_name, setting_value) VALUES ("'.$seting.'", "'.$value.'")';
        return $query;
    }
    /*
     * medota zwracająca string który jest formularzem dla opcji systemu
     */
    public function showForm(){
        $form = '<div id="settingForm">'
                . '<form action="PageSettings.php" method="post">';
        for($i = 0; $i < count($this->settings); $i++){
            $form = $form.''.$this->settings[$i].': <input type="text" id="'.$this->settings[$i].'" name="'.$this->settings[$i].'" value="'.$this->values[$i].'" ></input><br>';
            
        }
        $form = $form.'<input type="submit" id="submit" value="Zapisz ustawienia">';
        $form = $form.'</form></div>';
        return $form;
    }
    /*
     * metoda zwracająca query które updatuje wszytkie recordy w bazie danych, dodatkowo zmienia wartość w obiekcie
     */
    public function setSettingsToDatabase(){
        $query = '';
        for($i = 0; $i < count($this->settings); $i++){
            if(isset($_POST[$this->settings[$i]])){
                $query = $query.'UPDATE page_settings SET setting_value="'.$_POST[$this->settings[$i]].'" WHERE setting_name="'.$this->settings[$i].'";';
                $this->values[$i] = $_POST[$this->settings[$i]];
            }
        }
        return $query;
    }
}

$test = new PageSettings();
$test->setArrays(array("name1","name2"), array("value1","value2"));
echo $test->showForm();
echo "<br>";
echo $test->add("name3","value3");
echo $test->showForm();
echo "<br>";
echo $test->setSettingsToDatabase();