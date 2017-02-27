<?php
// <!-- 1. isset OU array_key_exists = vérification des variables
// 2. sécurisation/validation des données (ex : verification de longueur)
// 3. traitement des données (enregistrer les informations vers base de données)
// 4. redirection (PRG : POST REDIRECT GET) UX et Sécurité -->

if (isset($_POST['prod_name'], $_POST['prod_desc'], $_POST['price'], $_POST['image'], $_POST['stock'], $_POST['prod_cover'], $_POST['id_category'], $_SESSION['id']))
{
	// Etape 2 : Validation des données
	$userManager = new CategoryManager($db);
	$id_category = $userManager->findById($_SESSION['id']);
	
	$manager = new ProductManager($db);
	try
	{
	$product = $manager->create($_POST['prod_name'],$_POST['prod_desc'], $_POST['price'], $_POST['image'], $_POST['stock'], $id_category);
	if ($product)
		{
			// Etape 4
			header('Location: index.php?page=products');
			exit;
		}
		else
		{
			$errors[] = "Erreur interne";
		}
	}
	catch (Exceptions $e)// ExceptionS
	{
		$errors = $e->getErrors();// ->getMessage() => ->getErrors()
	}
	// $title = $_POST['title'];
	// $article = $_POST['article'];
	// if (strlen($title) > 63)
	// {
	// 	$errors[] = "Titre trop long (> 63)";
	// }
	// else if (strlen($title) < 5)
	// {
	// 	$errors[] = "Titre trop court (< 5)";
	// }
	// if (strlen($article) > 4094)
	// {
	// 	$errors[] = "Article trop long (> 4095)";
	// }
	// else if (strlen($article) < 2)
	// {
	// 	$errors[] = "Article trop court (< 20)";
	// }

	// Etape 3 : Traitement des données
	// if (count($errors)==0)
	// {
	// 	$title = mysqli_real_escape_string($db, $title);
	// 	$article = mysqli_real_escape_string($db, $article);
		// if ($article)
		// {
		// 	// Etape 4
		// 	header('Location: index.php?page=articles');
		// 	exit;
		// }
		// else
		// {
		// 	$errors[] = "Erreur interne";
		// }
		
	// 	mysqli_query($db, "INSERT INTO articles (title, id_author, article) VALUES('".$title."', '".$_SESSION['id']."', '".$article."')");
	
	// INSERT INTO articles (title, content, author) VALUES('titre', 'contenu', 'auteur')
	
	// header('Location: index.php?page=articles');

	// exit;
	// }
	
}
?>