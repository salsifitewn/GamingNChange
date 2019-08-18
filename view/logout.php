<?php
 session_start();
 //unset($_SESSION['connecte']);
 session_unset();
 unset($_COOKIE['cart']); 
    setcookie('cart'); 
 header('Location: /?logout=1');