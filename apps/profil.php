<?php
if (isset($_SESSION['id']))
{
	$manager = new UserManager($db);
	$user = $manager->findById($_SESSION['id']);
	require('views/profil.phtml');
}
?>