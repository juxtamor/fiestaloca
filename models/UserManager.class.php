<?php
class UserManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}


	// SELECT
	public function findAll()
	{
		$list = [];
		$res = mysqli_query($this->db, "SELECT * FROM users ORDER BY login");
		while ($user = mysqli_fetch_object($res, "User", [$this->db]))
		{
			$list[] = $user;
		}
		return $list;
	}
	public function findById($id)
	{
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$id = intval($id);
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM users WHERE id='".$id."' LIMIT 1");
		$user = mysqli_fetch_object($res, "User", [$this->db]); // $user = new User();
		return $user;
	}

	public function findByLogin($login)
	{
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\
		$login = mysqli_real_escape_string($this->db, $login);
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM users WHERE login='".$login."' LIMIT 1");
		$user = mysqli_fetch_object($res, "User", [$this->db]);
		return $user;
		
	}
	

	// UPDATE
	public function save(User $user)
	{
		$id = intval($user->getId());
		//		
		$login = mysqli_real_escape_string($this->db, $user->getLogin());
		$password = mysqli_real_escape_string($this->db, $user->getPassword());
		$email = mysqli_real_escape_string($this->db, $user->getEmail());
		$adress = mysqli_real_escape_string($this->db, $user->getAdress());
		$birthdate = mysqli_real_escape_string($this->db, $user->getBirthdate());
		$admin = mysqli_real_escape_string($this->db, $user->isAdmin());
		mysqli_query($this->db, "UPDATE users SET login='".$login."', password='".$password."', email='".$email."', adress='".$adress."', birthdate='".$birthdate."', admin='".$admin."' WHERE id='".$id."'LIMIT 1");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		return $this->findById($id);
	}

	
	// DELETE
	public function remove(User $user)
	{
		$id = intval($user->getId());
		mysqli_query($this->db, "DELETE from users WHERE id='".$id."' LIMIT 1");
		return $user;
	}

	
	// INSERT
	public function create($login, $password1, $password2, $email, $adress, $birthdate )
	{
		$errors = [];
		$user = new User($this ->db);
		if (($error = $user->setLogin($_POST['login'])))
			$errors[] = $error;
		if (($error = $user->initPassword($_POST['password1'], $_POST['password2'])))
			$errors[] = $error;
		if (($error = $user->setEmail($_POST['email'])))
			$errors[] = $error;
		if (($error = $user->setAddress($_POST['address'])))
			$errors[] = $error;
		if (($error = $user->setBirthdate($birthdate)))
			$errors[] = $error;
		
		if (count($errors) != 0)
		{
			throw new Exceptions($errors);
		}

		$login = mysqli_real_escape_string($this->db, $user->getLogin());
		// $hash = password_hash($password1, PASSWORD_BCRYPT, ["cost"=>11]);
		$hash = mysqli_real_escape_string($this->db, $user->getPassword());
		$email = mysqli_real_escape_string($this->db, $user->getEmail());
		$adress = mysqli_real_escape_string($this->db, $user->getAdress());
		$birthdate = mysqli_real_escape_string($this->db, $user->getBirthdate());
		$res = mysqli_query($this->db, "INSERT INTO users (login, password, email, adress, birthdate) VALUES('".$login."','".$hash."', '".$email."','".$adress."', '".$birthdate."')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne", mysqli_error($this->db)]);
		}
		$id = mysqli_insert_id($this->db);// last_insert_id
		return $this->findById($id);
	}
}
?>