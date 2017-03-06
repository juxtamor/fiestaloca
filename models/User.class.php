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

	private $cart;
	private $db;



	public function __construct($db)
	{
		$this->db = $db;
	}


	public function getId()
	{
		return $this->id;
	}


	public function getCart()
	{
		$manager = new CommandManager($this->db);
		$this->cart = $manager->findCartByUser($this);
		return $this->cart;
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
	public function verifPassword($password)
	{
		return password_verify($password, $this->password);
	}
	public function updatePassword($password, $old_password)
	{
		if (strlen($password) > 31)
		{
			return "Mot de passe trop long (> 31)";
		}
		else if (strlen($password) < 3)
		{
			return "Mot de passe trop court (<3)";
		}
		else if (!$this->verifPassword($old_password))
		{
			return "L'ancien mot de passe est invalide";
		}
		else
		{
			$this->password = password_hash($password, PASSWORD_BCRYPT, ["cost"=>11]);
		}
	}
	public function initPassword($password1, $password2)
	{
		if (strlen($password1) > 31)
		{
			return "Mot de passe trop long (> 31)";
		}
		else if (strlen($password1) < 3)
		{
			return "Mot de passe trop court (< 3)";
		}
		else if ($password1 != $password2)
		{
			return "Les mots de passe ne correspondent pas";
		}
		else if ($this->password != null)
		{
			return "Vous ne pouvez pas initialiser un mot de passe deja existant";
		}
		else
		{
			$this->password = password_hash($password, PASSWORD_BCRYPT, ["cost"=>11]);
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
			return "Adress trop long (> 511)";
		}
		else if (strlen($adress) < 3)
		{
			return "Adress trop courte (< 3)";
		}
		
		else{
			$this->adress = $adress;
		}
	}


	public function getBirthdate()
	{
		return $this->birthdate;
	}
	public function setBirthdate($birthdate)
	{
		if($birthdate!=true)
		{
			return "date non valide";
		}
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
		else
		{
			return "date de naissance non valide";
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