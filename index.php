<?php
//var_dump($_SERVER['HTTP_REFERER']);
$errors=[];

$db = mysqli_connect("192.168.1.79","fiestaloca","fiestaloca","fiestaloca"); //URL, Utilisateur, MdP, Base de données//
session_start();// http://php.net/manual/fr/function.session-start.php
$access = ["errors", "products", "login", "register", "create_product", "edit_product", "product", "accueil","profil","cart", "create_categorie", "categorie", "result","edit_categorie","all_products","edit_product"];
$page = "accueil";
if (isset($_GET['page']) && in_array($_GET['page'], $access))
{
    $page = $_GET['page'];
}

// __autoload : http://php.net/manual/fr/function.autoload.php
function __autoload($classname)
{
	require('models/'.$classname.'.class.php');
}


$access_traitement = ["login"=>"users", "register"=>"users", "logout"=>"users", "create_categorie"=>"categorie", "cart"=>"command", "user"=>"users", "create_product"=>"products", "product"=>"comments"];
if (isset($_GET['page'], $access_traitement[$_GET['page']]))
{
	$traitement = $access_traitement[$_GET['page']];
	require('apps/traitement_'.$traitement.'.php');
}

require('apps/skel.php');
?>