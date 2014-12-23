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
}
?>