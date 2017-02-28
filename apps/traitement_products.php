<?php
// <!-- 1. isset OU array_key_exists = vérification des variables
// 2. sécurisation/validation des données (ex : verification de longueur)
// 3. traitement des données (enregistrer les informations vers base de données)
// 4. redirection (PRG : POST REDIRECT GET) UX et Sécurité -->
// var_dump($_POST);

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
}
?>