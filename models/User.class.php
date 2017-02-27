<?php
class User
{
	// liste des propriétés -> privées
	private $id;
	private $login;
	private $password;
	private $user_email;
	private $birthdate;
	private $admin;

	public function getId()
	{
		return $this->id;
	}

	public function getLogin()
	{
		return $this->login;
	}
	public function setLogin($login)
	{
		if (strlen($login) > 31)
		{
			return "Login trop long (> 31)";
		}
		else if (strlen($login) < 3)
		{
			return "Login trop court (< 3)";
		}
		else
		{
			$this->login = $login;
		}
	}


	public function getPassword()
	{
		return $this->password;
	}
	public function setPassword($password)
	{
		if (strlen($password) > 31)
		{
			return "Mot de passe trop long (> 71)";
		}
		else if (strlen($password) < 3)
		{
			return "Mot de passe trop court (< 8)";
		}
		else
		{
			$this->password = $password;
		}
	}

	public function getUserEmail()
	{
		return $this->user_email;
	}
	public function setUserEmail($user_email)
	{
		if (filter_var($user_email, FILTER_VALIDATE_EMAIL) == true)
		{
			$this->user_email = $user_email;
		}
		else
		{
			return "Email non valide";
		}
	}

	public function getBirthdate()
	{
		return $this->birthdate;
	}
	public function setBirthdate($birthdate)
	{
		var_dump($birthdate);
		// $birthdate => 2017-02-22
		// explode / implode
		// string => array / array => string
		$tab = explode('-', $birthdate);
		// ["2017", "02", "22"]
		$month = $tab[1];
		$day = $tab[2];
		$year = $tab[0];
		// http://php.net/manual/fr/function.checkdate.php
		if (checkdate($month, $day, $year) == true)
		{
			$this->birthdate = $birthdate;
		}
	}

	public function isAdmin()
	{
		return $this->admin;
	}
	public function setAdmin($admin)
	{
		if (is_bool($admin))
		$this->admin;
	}




}
?>