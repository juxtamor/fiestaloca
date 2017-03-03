<?php

if (isset($_SESSION['id']))
{	
	$manager = new UserManager($db);
	$user = $manager->findById($_SESSION['id']);
	$cart = $user->getCart();


 if ($cart)
	{
	
		require('views/cart.phtml');
	}
	else 
	{
		$errors[] = "Il n'y a pas de panier";
		require ('views/errors.phtml');
	}
}
?>