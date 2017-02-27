<?php
$errors=[];
// try
// {
// throw new Exception("Erreur de test d'erreur... <3");
// }
// catch(Exception $exception)
// {
// $errors[] = $exception->getMessage();
// }
// try
// {
// throw new Exception("Erreur de test d'erreur... le retour <3");
// }
// catch(Exception $exception)
// {
// $errors[] = $exception->getMessage();
// }
$db = mysqli_connect("192.168.1.79","fiestaloca","fiestaloca","fiestaloca"); //URL, Utilisateur, MdP, Base de données//
session_start();// http://php.net/manual/fr/function.session-start.php
$access = ["articles", "login", "register", "create_article", "edit_article", "article"];
$page = "products";
if (isset($_GET['page']) && in_array($_GET['page'], $access))
{
    $page = $_GET['page'];
}
require('models/Exceptions.class.php');

require('models/User.class.php');
require('models/Comment.class.php');
require('models/Product.class.php');
require('models/UserManager.class.php');
require('models/CommentManager.class.php');
require('models/ProductManager.class.php');

require('apps/traitement_users.php');
require('apps/traitement_products.php');
require('apps/traitement_comments.php');

require('apps/skel.php');


?>