<?php
class User
{
	// liste des propriétés -> privées
	private $id;
	private $login;
	private $password;
	private $email;
	private $adress;
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

	public function getEmail()
	{
		return $this->email;
	}
	public function setEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL) == true)
		{
			$this->email = $email;
		}
		else
		{
			return "Email non valide";
		}
	}

	public function getAdress()
	{
		return $this->adress;
	}
	public function setAdress($adress)
	{
		if (strlen($adress) > 511)
		{
			return "Adress trop long (> 71)";
		}
		else if (strlen($adress) < 3)
		{
			return "Adress trop courte (< 8)";
		}
		else
		{
			return "Adress non valide";
		}
	}

	public function getBirthdate()
	{
		return $this->birthdate;
	}
	public function setBirthdate($birthdate)
	{
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