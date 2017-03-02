<?php
// <!-- 1. isset OU array_key_exists = vérification des variables
// 2. sécurisation/validation des données (ex : verification de longueur)
// 3. traitement des données (enregistrer les informations vers base de données)
// 4. redirection (PRG : POST REDIRECT GET) UX et Sécurité -->
// var_dump($_POST);
if (isset($_POST['cat_name'], $_POST['cat_desc'])) //$_SESSION['id']))
{
	// Etape 2 : Validation des données
	$manager = new CategorieManager($db);
	try
	{
		$categorie = $manager->create($_POST['cat_name'],$_POST['cat_desc']);
		if ($categorie)
		{		// Etape 4
			header('Location: index.php?page=create_categorie');
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