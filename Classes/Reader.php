<?php
include_once "User.php";
class Reader extends User{
    private $active;

    public function __construct($a, $c, $u = -1){
	parent::__construct($c, $u);
        $this->active = $a;
    }
    public function session(){
        $this->controller->updateTableRecordValuesWhere("sessions", 
                array(array("session_last_action", date('Y-m-d H:i:s'))),
                array(
                    array("session_user", $this->userID, "AND"),
                    array("session_acces_right","=", "reader", "")
                    ));
    }
    public function showOptionPanel(){
        if(!$this->checkSession()){
                $this->timeOut();
            }
		$userData = $this->getData($this->userID);
		return '<div id="panelName">Panel użytkownika</div>
			<p align="center">
				Witamy '.$userData['reader_name'].'!
			</p>
			<ul>
				<li><a href="'.backToFuture().'Library/UserAction/profile.php">Twój profil</a></li>
				<li><a href="'.backToFuture().'Library/UserAction/my_borrows.php">Twoje wypożyczenia</a></li>
				<li><a href="'.backToFuture().'Library/UserAction/logout.php">Wyloguj</a></li>
			</ul>
                        session id =
                        '.session_id().' logger = 
			'.$_SESSION['logged'].' userid =
			'.$_SESSION['user_id'].' ip =
			'.$_SESSION['ip'].' access = 
			'.$_SESSION['acces_right'].' class.userID =
                        '.$this->userID.' class.active =
                        '.$this->active.'';
	}
    public function showNews(){
            return parent::showNews();
        }
    public function showBook($bookID){
            $resultFreeBook = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("free_books", 
                        array("*"),
                        null,
                        array(
                              array("book_id","=", $bookID, " ")
                              ));
            $rowFreeBook = mysqli_fetch_assoc($resultFreeBook);
            if (($rowFreeBook['free_books'] == 0 || $this->active == 0) && $rowFreeBook['free_books'] != null){
                $active = "disabled";
            }
            return  parent::showBook($bookID, $active);
        }
    public function showBorrow($borrowID){
        $borrow = "";
        $borrowResult = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("borrows", null, null,
                array(array("borrow_id","=", $borrowID, "")));
        $row = mysqli_fetch_array($borrowResult);
        $borrow = $borrow.'<p>Data wypożyczenia: '.$row['borrow_date_borrow'].'<br>Data zwrotu: '.$row['borrow_return'].'<br>Opóźnienie: '.$row['borrow_delay_date'].'<br> Kwota do zapłaty za opóźnienie: </p>';
        $borrow = $borrow.'<div id="book" align="center">Książka:<br>'.$this->showBookLight($row['borrow_book_id']).'</div>';
        
        return $borrow;
    }  
    public function showMyBorrows(){
        $myBorrows = "";
        $result = $this->controller->selectTableWhatJoinWhereGroupOrderLimit("borrows", null, null, array(array("borrow_reader_id","=", $this->userID, "")));
        while($row = mysqli_fetch_array($result)){
            $myBorrows = $myBorrows.$this->showBorrow($row['borrow_id']);
            $myBorrows = $myBorrows.'<p>------------------------------------------</p>';
        }
        return $myBorrows;
    }
    public function showAccount(){
		$userData = $this->getData($this->userID);
		return '<p>
                            ID: '.$userData['reader_id'].'<br>
                            Imie: '.$userData['reader_name'].'<br>
                            Nazwisko: '.$userData['reader_surname'].'<br>
                            Login: '.$userData['reader_login'].'<br>
                            Email: '.$userData['reader_email'].'<br>
                            Konto aktywne do: '.$userData['reader_active_account'].'<br>
                            Adres: '.$userData['reader_address'].'<br>	
                            Prawa: '.$userData['acces_right_name'].'<br>					
			</p>';
	}
    public function getData($ID){
	return $this->controller->getReaderData($this->userID);
    }
    public function orderBook($bookID) {
        $date = date('Y-m-d');
        $dateReturn = date_create(date('Y-m-d'));
	date_add($dateReturn, date_interval_create_from_date_string('60 days'));
        $this->controller->insertTableRecordValue("borrows",
                array("borrow_book_id", "borrow_reader_id", "borrow_date_borrow", "borrow_return"),
                array($bookID, $this->userID, $date, date_format($dateReturn,"y-m-d")));
        echo 'Zamówiono książke. Odbiór w najbliższych 3 dniach';
        }
}
?>