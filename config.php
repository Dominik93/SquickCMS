<?php
include "controller.php";
include "special_user.php";



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

function templateTable($controller, $array, $arrayTable, $table, $tableStyle, $link = null, $join = null, $where = null){
            $result = $controller->selectTableWhatJoinWhereGroupOrderLimit($table, null, $join, $where);
            $return = '<div id="'.$tableStyle.'" align="center">
                            <table>
                                <tr>';
            foreach ($array as $s){
                $return = $return.'<td align="center"><input placeholder="'.$s.'" style="width: 60%;" type="text" id="'.str_replace(' ', '', $s).'">'.'</td>';
            }
            $return = $return.'</tr><tr>';
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
                    $return = $return.'<tr onClick="location.href=\'http://localhost/~dominik/Library/'.$link.'='.$row[0].'\'" />';
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
CreateOwner();
if(!isset($_SESSION['logged'])) {
	$_SESSION['id'] = session_id();
        $_SESSION['logged'] = false;
        $_SESSION['user_id'] = -1;
	$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
	$_SESSION['acces_right'] = "user";
	$_SESSION['user'] = serialize(new User(new Controller()));
}
?>
