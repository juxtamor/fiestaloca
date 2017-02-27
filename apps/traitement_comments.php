<?php
// var_dump($_POST);
if (isset($_POST['comment'], $_POST['id_prod'], $_SESSION['id']))
{
	// Etape 2
	$userManager = new UserManager($db);
	$author = $userManager->findById($_SESSION['id']);

	$productManager = new ProductManager($db);
	$product = $productManager->findById($_POST['id_prod']);
	
	$manager = new CommentManager($db);
	try
	{
		// Etape 3
		$comment = $manager->create($_POST['comment'], $author, $product);
		if ($comment)
		{
			// Etape 4
			header('Location: index.php?page=article&id='.$comment->getProd()->getId());
			exit;
		}
		else
		{
			$errors[] = "Erreur interne";
		}
	}
	catch (Exceptions $e)
	{
		$errors = $e->getErrors();
	}
}
?>