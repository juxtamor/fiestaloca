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
				
			$manager = new UserManager($db);
			try
			{
				$user = $manager->create($_POST['login'], $_POST['password1'], $_POST['password2'], $_POST['email'],$_POST['adress'], $_POST['birthdate']);
				if ($user)
				{
					header('Location: index.php?page=login');
					exit;
				}
				else
				{
					$user1 = $manager->findByEmail($_POST['email']);
					$user2 = $manager->findByLogin($_POST['login']);
					if ($user1)
					{
						$errors[] = "Email deja existant";
					}
					else if ($user2)
					{
						$errors[] = "Login deja existant";
					}
					else
					{
						$errors[] = "Erreur interne";
					}
				}
			}
			catch (Exceptions $e)
			{
				$errors = $e->getErrors();
			}
		}
	}
	else if ($action == "login")
	{
		if (isset($_POST['login'], $_POST['password']))
		{
			$manager = new UserManager($db);
			try
			{
					$user = $manager->findByLogin($_POST['login']);
					if ($user)
					{
						//if (password_verify($_POST['password'], $user->getPassword()))
						if ($user->verifPassword($_POST['password']))
						{
							$_SESSION['id'] = $user->getId();
							$_SESSION['login'] = $user->getLogin();
							$_SESSION['admin'] = $user->isAdmin();
						
							header('Location: index.php');
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
	else if ($action == "update")
	{
		if (isset($_SESSION['id'], $_POST['login'], $_POST['password1'], $_POST['password2'], $_POST['email'],$_POST['adress'], $_POST["old_password"]))
		{
			$manager = new UserManager($db);
			try
			{
				$user = $manager->findByLogin($_POST['login']);
				if ($user)
				{
					//if (password_verify($_POST['password'], $user->getPassword()))
					if ($user->verifPassword($_POST['password']))
					{
						if (($error = $user->setLogin($_POST['login'])))
							$errors[] = $error;
						if (($error = $user->updatePassword($_POST['password'], $_POST['old_password'])))
							$errors[] = $error;
						if (($error = $user->setEmail($_POST['email'])))
							$errors[] = $error;
						if (($error = $user->setAddress($_POST['address'])))
							$errors[] = $error;

						if (count($errors) == 0)
						{
							$manager->save($user);
							$_SESSION['login'] = $user->getEmail();
							
							header('Location: index.php');
							exit;
						}
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
?>