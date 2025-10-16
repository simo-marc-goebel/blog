<?php


$page = $_GET['page'] ?? 'home';

switch ($page) {
    case 'postDetails':
        require 'pages/postDetails.html';
        break;
    case 'posts':
        require 'posts.php';
        break;
    default:
        require 'pages/indexold.html';
}
