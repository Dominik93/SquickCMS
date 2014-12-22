<?php

interface IUser{
	public function showOptionPanel();
	public function getData();
	public function showNews($controller);
	public function showMainPage();
	public function showRegulation();
	public function showHours();
	public function showSearch();
	public function showContact();
}
?>