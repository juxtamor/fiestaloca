<?php
if(isset($_GET['id']))
{
	$manager = new ProductManager($db);
	$product = $manager->findById($_GET['id']);
	// $id = intval($_GET['id']);
	// $res = mysqli_query($db, "SELECT articles.*,users.login FROM  articles , users WHERE users.id=articles.id_author AND articles.id=".$id);
	// $article = mysqli_fetch_assoc($res);
	if($product)
	{
		
		require('views/product.phtml');
	}
	else
	{
		$errors[]="Le produit n'existe pas";
		require('apps/errors.php');
	}
}
else
{
	$errors[]="Le produit n'existe pas";
	require('apps/errors.php');
}
?>