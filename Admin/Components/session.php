<?php 
session_start();
if(!isset($_SESSION['username']) || !isset($_SESSION['is_admin'])){
    header("location:Dashboard.php");
}