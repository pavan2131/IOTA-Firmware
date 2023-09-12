<?php 
$title="Dashboard";
include 'header.php';
is_logged_in();
include 'sidebar.php';
if(get('login')){
    success("Login Success");
}





include 'footer.php';