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
        public function logout();
        public function showLogin();
        public function login($login, $password);
        public function session();
        public function search($isbn, $title, $publisher_house, $edition, $premiere, $author);
        public function checkSession();
        /*
         * childs
         */
	public function showOptionPanel();
        public function showNews();
	public function getData();
	public function showLogged();
	public function showRegistrationReader();
        public function showAllUsers();
	public function addReader($login, $email, $name, $surname, $password1, $password2, $adres);
        public function showAccount(); 
        public function showAllBooks();
        public function showBookAdd();
        public function addBook($isbn, $title, $publisher_house, $nr_page, $edition, $premiere, $number, $author);
        public function showAllAdmins();
        public function addAdmin($name, $surname, $password1, $password2, $email, $login);
        public function showRegistrationAdmin();
        public function isActive();
        public function showBook($bookID);
        public function orderBook($bookID);
        public function showAllBorrows();            
}
?>