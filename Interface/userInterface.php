<?php

interface IUser{
        /*
         * user
         */
	public function showMainPage();
	public function showHours();
        public function showSearch();
	public function showContact();
	public function showRegulation();
        public function showLogin();
        public function logout();
        public function login($login, $password);
        public function session();
        public function search($isbn, $title, $publisher_house, $edition, $premiere, $author);
        public function checkSession();
        /*
         * admin and reader
         */
	public function showOptionPanel();
        public function showNews();
        public function showAccount(); 
	public function showLogged();  
        public function showAddBookForm();  
        public function showAddNewsForm();
	public function showRegistrationReader();
        public function showRegistrationAdmin();
        public function showAllUsers();
        public function showAllAdmins();
        public function showAllBorrows();
        public function showAllBooks();
        public function showAdmin($adminID);
        public function showReader($readerID);
        public function showEditReader($readerID);
        public function showBook($bookID);
        public function showBookLight($bookID);
        public function showBorrow($borrowID);
        public function showMyBorrows();
	public function addReader($login, $email, $name, $surname, $password1, $password2, $adres);
        public function editReader($login, $email, $name, $surname, $adres);
        public function addBook($isbn, $title, $publisher_house, $nr_page, $edition, $premiere, $number, $author);
        public function addAdmin($name, $surname, $password1, $password2, $email, $login);
        public function addNews($title, $text);
        public function deleteNews($id);
        public function orderBook($bookID);
        public function isActive($ID);
	public function getData($ID);
}
?>