<?php
// <!-- 1. isset OU array_key_exists = vérification des variables
// 2. sécurisation/validation des données (ex : verification de longueur)
// 3. traitement des données (enregistrer les informations vers base de données)
// 4. redirection (PRG : POST REDIRECT GET) UX et Sécurité -->
// var_dump($_POST);

if (isset($_GET['page']) && $_GET['page'] == "logout")
{
	session_destroy();
	header('Location: index.php');
	exit;
}
if (isset($_POST['action']))
{
	$action = $_POST['action'];
	if ($action == "register")
	{
		if (isset($_POST['login'], $_POST['password1'], $_POST['password2'], $_POST['email'],$_POST['adress'], $_POST['birthdate']))
		{
			// Etape 2 : Validation des données
		$manager = new UserManager($db);
		try
		{
		$user = $manager->create($_POST['login'], $_POST['password1'], $_POST['password2'], $_POST['email'],$_POST['adress'], $_POST['birthdate']);
		if ($user)
			{
				// Etape 4
				header('Location: index.php?page=login');
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
	}
		if ($action == "login")
	{
		// Etape 1
		if (isset($_POST['login'], $_POST['password']))
		{
			// Etape 2
			$manager = new UserManager($db);
			try
			{
				// Etape 3
				$user = $manager->findByLogin($_POST['login']);
				if ($user)
				{
					if (password_verify($_POST['password'], $user->getPassword()))
					{
						$_SESSION['id'] = $user->getId();
						$_SESSION['login'] = $user->getLogin();
						$_SESSION['admin'] = $user->isAdmin();
						// Etape 4
						header('Location: index.php?page=articles');
						exit;
					}
					else
					{
						$errors[] = "Mot de passe incorrect";
					}
				}
				else
				{
					$errors[] = "Login inconnu";
				}
			}
			catch (Exceptions $e)
			{
				$errors = $e->getErrors();
			}
		}
	}
}
?>