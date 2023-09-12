<?php 
include 'header.php';

include 'navbar.php';

if(get('logout')){
    success("Logout Success");
}



include 'footer.php';



// $userProperties = [
//     'email' => 'anoopn@gmail.com',
//     'emailVerified' => false,
//     'phoneNumber' => '+919886162566',
//     'password' => 'secretPassword',
//     'displayName' => 'John Doe',
//     'photoUrl' => 'http://www.example.com/12345678/photo.png',
//     'disabled' => false,
// ];

// $createdUser = $auth->createUser($userProperties);

// echo "<pre>";
// print_r($createdUser);
// echo "</pre>";
// //get uid
// $uid = $createdUser->uid;
// echo $uid;