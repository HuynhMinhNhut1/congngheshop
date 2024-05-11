<?php
session_start();
require_once __DIR__ . "/../../libraries/Database.php";
require_once __DIR__ . "/../../libraries/Function.php";
$db = new Database;
$con = mysqli_connect("localhost", "root", "", "shopcongnghe");
//create address save Images 
define("ROOT", $_SERVER['DOCUMENT_ROOT'] . "/public/uploads/");
$category = $db->fetchAll("category");
//Login 
if (!isset($_SESSION['admin_id'])) {
    header("location:/login/");
}
