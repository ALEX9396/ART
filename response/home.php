<?php
echo 'Home';

// require __DIR__."/../helper/catalogue.php";

CSRF::generate('auth');
CSRF::generate('cart');

var_dump($_SESSION);
?>