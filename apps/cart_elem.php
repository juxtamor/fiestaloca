<?php
	$manager = new UserManager($db);
	$user = $manager->findById($_SESSION['id']);
	$cart = $user->getCart();
	//$list = $user->getCommand();
	if ($cart)
	{
		$list = $cart->getProducts();
		foreach ($list AS $product)
		require('views/cart_elem.phtml');
	}
	else 
	{
		$errors[] = "Erreur interne";
	}
?>