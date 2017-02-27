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
		while ($user = mysqli_fetch_object($res, "User"))
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
		$user = mysqli_fetch_object($res, "User"); // $user = new User();
		return $user;
	}

	public function findByLogin($login)
	{
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\ SECURITE
		$login = mysqli_real_escape_string($this->db, $login);
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM users WHERE login='".$login."' LIMIT 1");
		$user = mysqli_fetch_object($res, "User");
		return $user;
		
	}
	
	// UPDATE
	public function save(User $user)
	{
		$id = intval($user->getId());
		//			
		$user_email = mysqli_real_escape_string($this->db, $user->getUserEmail());
		$password = mysqli_real_escape_string($this->db, $user->getPassword());
		$login = mysqli_real_escape_string($this->db, $user->getLogin());
		$birthdate = mysqli_real_escape_string($this->db, $user->getBirthdate());
		$admin = mysqli_real_escape_string($this->db, $user->getAdmin());
		mysqli_query($this->db, "UPDATE users SET user_email='".$user_email."', password='".$password."', login='".$login."', birthdate='".$birthdate."', admin='".$admin."' WHERE id='".$id."'LIMIT 1");
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
	public function create($login, $password1, $password2, $birthdate, $email)
	{
		$errors = [];
		$user = new User();
		$error = $user->setLogin($login);// return
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $user->setPassword($password1);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $user->setBirthdate($birthdate);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $user->setUserEmail($email);
		if ($error)
		{
			$errors[] = $error;
		}
		if (count($errors) != 0)
		{
			throw new Exceptions($errors);
		}

		$login = mysqli_real_escape_string($this->db, $user->getLogin());
		$email = mysqli_real_escape_string($this->db, $user->getUserEmail());
		$birthdate = mysqli_real_escape_string($this->db, $user->getBirthdate());
		$hash = password_hash($password1, PASSWORD_BCRYPT, ["cost"=>11]);
		$res = mysqli_query($this->db, "INSERT INTO users (user_email, password, login, birthdate) VALUES('".$email."', '".$hash."', '".$login."', '".$birthdate."')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne", mysqli_error($this->db)]);
		}
		$id = mysqli_insert_id($this->db);// last_insert_id
		return $this->findById($id);
	}
}
?>