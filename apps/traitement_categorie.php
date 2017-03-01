
<?php
// var_dump($_POST);
if (isset($_POST['cat_name'], $_POST['cat_desc']))
{
	// Etape 2
	$productManager = new ProductManager($db);
	$author = $userManager->findById($_POST['cat_name']);

	$productManager = new ProductManager($db);
	$product = $productManager->findById($_POST['cat_desc']);
	
	$manager = new CategorieManager($db);
	try
	{
		// Etape 3
		//  public function create($comment, $id_author, $id_article) -> CommentManager.class.php ligne 59
		// 	$comment = $manager->create($_POST['comment'], $_SESSION['id'], $_POST['id_article']);
		$comment = $manager->create($_POST['comment'], $author, $article);
		if ($comment)
		{
			// Etape 4
			header('Location: index.php?page=article&id='.$comment->getArticle()->getId());
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