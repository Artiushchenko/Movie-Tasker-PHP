<?php
$connection = mysqli_connect('db', 'root', 'admin', 'movie_tasker');

if(!$connection){
    die('Connection failed: ' . mysqli_connect_error());
}