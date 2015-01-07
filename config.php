<?php

function backToFuture(){
    $path = getcwd();
    $future= "";
    $pathExplode = explode("/", $path);
    $i = count($pathExplode) - 1;
    
    while($pathExplode[$i] != "public_html"){
        array_pop($pathExplode);
        $future.="../";
        $i--;
    }
    $path = implode("/", $pathExplode);
    return $future;
}

include backToFuture()."Library/Layout/layout.php";
include backToFuture()."Library/Classes/Controller.php";
include backToFuture()."Library/Classes/Admin.php";
include backToFuture()."Library/Classes/Reader.php";

function Codepass($password) {
    return sha1(md5($password).'#!%Rgd64');
}

function CreateOwner(){
	$controller = new Controller();
	$result = $controller->selectTableWhatJoinWhereGroupOrderLimit("admins", array("admin_login"),null,array(array("admin_login","=","dslusarz","")));
	if(mysqli_num_rows($result) == 0){
            $result = $controller->selectTableWhatJoinWhereGroupOrderLimit("acces_rights",null,null,array(array("acces_right_name", "=", "admin","")));

            if(mysqli_num_rows($result) == 0) {
                die('Błąd');
            }
            $row = mysqli_fetch_assoc($result);

            $controller->insertTableRecordValue("admins",
                    array("admin_login", "admin_password", "admin_email", "admin_name", "admin_surname", "admin_acces_right_id"),
                    array("dslusarz", Codepass('wiosna'), "slusarz.dominik@gmail.com", "Dominik", "Ślusarz", $row['acces_right_id']));
        }
}

function templateForm($name, $arrayDiv, $arrayForm, $arrayTable, $arrayFormInput, $arraySubmit, $arraySpan = null){
            $form = '<div';
            for($i = 0; $i < count($arrayDiv); $i++){
                $form = $form.' '.$arrayDiv[$i][0].' '.$arrayDiv[$i][1].'"'.$arrayDiv[$i][2].'"';
            }
            $form = $form.'><p>'.$name.'</p>';
            $form = $form.'<form';
            for($i = 0; $i < count($arrayForm); $i++){
                $form = $form.' '.$arrayForm[$i][0].' '.$arrayForm[$i][1].'"'.$arrayForm[$i][2].'"';
            }
            $form = $form.'>';
            // "isbn" ""
            $form = $form.'<table';
            for($i = 0; $i < count($arrayTable); $i++){
                $form = $form.' '.$arrayTable[$i][0].' '.$arrayTable[$i][1].'"'.$arrayTable[$i][2].'"';
            }
            $form = $form.'>';
            for($i = 0; $i < count($arrayFormInput); $i++){
                $form = $form.'<tr>';
                $form = $form.'<td><input';
                for($j = 0; $j < count($arrayFormInput[$i]); $j++){
                    $form = $form.' '.$arrayFormInput[$i][$j][0].''.$arrayFormInput[$i][$j][1].'"'.$arrayFormInput[$i][$j][2].'"';
                }  
                if($arraySpan != null){
                    $form = $form.'/>'.$arraySpan[$i].'</td>';
                }
                else{
                    $form = $form.'/></td>';
                }    
                $form = $form.'</tr>';
            }
            $form = $form.'</table>';
            $form = $form.'<input';
            for($i = 0; $i < count($arraySubmit); $i++){
                $form = $form.' '.$arraySubmit[$i][0].' '.$arraySubmit[$i][1].'"'.$arraySubmit[$i][2].'"';
            }
            $form = $form.'/>';
            $form = $form.'</form></div>';
            return $form;
        }

function templateTable($controller, $array, $arrayTable, $table, $tableStyle, $link = null, $what = null, $join = null, $where = null){
            $result = $controller->selectTableWhatJoinWhereGroupOrderLimit($table, $what, $join, $where);
            $return = "";
            $return .= '<div id="'.$tableStyle.'" align="center">
                            <table>';
            $return = $return.'<tr>';
            foreach ($array as $s){
                $return = $return.'<td>'.$s.'</td>';
            }
            $return = $return.'</tr>';
            if(mysqli_num_rows($result) == 0) {
		return $return."</table></div>";
            }
            while($row = mysqli_fetch_array($result)) {
                if($link == null){
                   $return = $return.'<tr>'.$row['reader_id'].'</tr>';
                }
                else{
                    $return = $return.'<tr onClick="location.href=\'http://torus.uck.pk.edu.pl/~dslusarz/Library/AdminAction/'.$link.'='.$row[0].'\'" />';
                }
		for($i = 0; $i< count($array); $i++){
                    $return = $return.'<td>'.$row[$arrayTable[$i]].'</td>';
                }
                $return = $return.'<tr>';
            }
            $return = $return.'</table></div>';
            return $return;
        }

session_start();
//CreateOwner();
if(!isset($_SESSION['logged'])) {
	$_SESSION['id'] = session_id();
        $_SESSION['logged'] = false;
        $_SESSION['user_id'] = -1;
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['acces_right'] = "user";
	$_SESSION['user'] = serialize(new User(new Controller()));
}
?>