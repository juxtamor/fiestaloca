<?php
class CommandManager
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
		$res = mysqli_query($this->db, "SELECT * FROM command ORDER BY id");
		while ($command = mysqli_fetch_object($res, "Command", [$this->db]))
		{
			$list[] = $command;
		}
		return $list;
	}
	public function findById($id)
	{
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$id = intval($id);
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM command WHERE id='".$id."' LIMIT 1");
		$command = mysqli_fetch_object($res, "Command", [$this->db]); // $command = new Article();
		return $command;
	}

	public function findByUser($id_user)
	{
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\ SECURITE
		$id_user = mysqli_real_escape_string($this->db, $id_user);
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM command WHERE id_user='".$id_user."' LIMIT 1");
		$command = mysqli_fetch_object($res, "Command", [$this->db]);
		return $command;
		
	}
	
	// UPDATE
	public function save(Command $command)
	{
		$id = intval($command->getId());
		//			
		$status = mysqli_real_escape_string($this->db, $command->getStatus());
		$total_price = intval($command->getTotalPrice());
		$id_user= intval($this->db, $command->getUser());
		mysqli_query($this->db, "UPDATE command SET ='".$status."', id_user='".$id_user."',total_price='".$total_price"' WHERE id='".$id."'LIMIT 1");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		return $this->findById($id);
	}
	
	// DELETE
	public function remove(Command $command)
	{
		$id = intval($command->getId());
		mysqli_query($this->db, "DELETE from command WHERE id='".$id."' LIMIT 1");
		return $command;
	}
	
	// INSERT
	public function create($status, $command, User $user)
	{
		$errors = [];
		$command = new Command($this->db);
		$error = $command->setUser($user);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $command->setStatus($status);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $command->setTotalPrice($total_price);
		if ($error)
		{
			$errors[] = $error;
		}
		if (count($errors) != 0)
		{
			throw new Exceptions($errors);
		}

		
		$status = mysqli_real_escape_string($this->db, $command->getStatus());
		$total_price = intval($command->getTotalPrice());
		$user= intval($this->db, $command->getUser()->getId());
		$res =mysqli_query($this->db, "INSERT INTO command (status, id_user, total_price) VALUES('".$status."', '".$id_user."', '".$total_price."')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		$id = mysqli_insert_id($this->db);
		return $this->findById($id);
	}
}
?>