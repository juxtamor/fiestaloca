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

	public function findByUser(User $user)
	{
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\ SECURITE
		$id_user = mysqli_real_escape_string($this->db, $id_user);
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM command WHERE id_user='".$id_user."'");
		$command = mysqli_fetch_object($res, "Command", [$this->db]);
		return $command;
		
	}
	
	public function findCartByUser(User $user)
	{
		$id_user = intval($user->getId());
		$res = mysqli_query($this->db, "SELECT * FROM command WHERE id_user='".$id_user."' AND status='Panier' LIMIT 1");
		$command = mysqli_fetch_object($res, "Command", [$this->db]);
		return $command;
	}


	// UPDATE
	public function save(Command $command)
	{
		$id = intval($command->getId());
		$products = $command->getProducts();
		$productManager = new ProductManager($this->db);
		mysqli_query($this->db, "DELETE FROM link_command_products WHERE id_command='".$id."'");
		$count = 0;
		while ($count < count($products))
		{
			$product = $products[$count];
			mysqli_query($this->db, "INSERT INTO link_command_products (id_command, id_products) VALUES('".$id."', '".$products[$count]->getId()."')");
			$product->setStock($product->getStock() - 1);
			$productManager->save($product);
			$count++;
		}
		//
		$id_user = intval($command->getUser()->getId());
		$status = mysqli_real_escape_string($this->db, $command->getStatus());
		$total_price = floatval($command->getTotalPrice());
		$res = mysqli_query($this->db, "UPDATE command SET status='".$status."', id_user='".$id_user."',total_price='".$total_price."' WHERE id='".$id."' LIMIT 1");
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
	public function create(User $user)
	{
		$errors = [];
		$command = new Command($this->db);
		$error = $command->setUser($user);
		if ($error)
		{
			$errors[] = $error;
		}
		if (count($errors) != 0)
		{
			throw new Exceptions($errors);
		}

		
		$id_user = intval($command->getUser()->getId());
		$res =mysqli_query($this->db, "INSERT INTO command (id_user) VALUES('".$id_user."')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		$id = mysqli_insert_id($this->db);
		return $this->findById($id);
	}
}
?>