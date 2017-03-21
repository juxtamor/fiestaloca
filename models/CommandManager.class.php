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
		// $list = [];
		// $res = mysqli_query($this->db, "SELECT * FROM command ORDER BY id");
		// while ($command = mysqli_fetch_object($res, "Command", [$this->db]))
		// {
		// 	$list[] = $command;
		// }
		// return $list;
		$request = $this->db->query("SELECT * FROM command ORDER BY id");
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Command", [$this->db]);
		return $list;
	}

	public function findById($id)
	{
		// // /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		// $id = intval($id);
		// // /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		// $res = mysqli_query($this->db, "SELECT * FROM command WHERE id='".$id."' LIMIT 1");
		// $command = mysqli_fetch_object($res, "Command", [$this->db]); // $command = new Article();
		// return $command;
		$request = $this->db->prepare("SELECT * FROM command WHERE id=? LIMIT 1");
		$request->execute([$id]);
		$command = $request->fetchObject("Command",[$this->db]);
		return $command;
	}

	public function findByUser(User $user)
	{
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\ SECURITE
		// $id_user = mysqli_real_escape_string($this->db, $id_user);
		// // /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\
		// $res = mysqli_query($this->db, "SELECT * FROM command WHERE id_user='".$id_user."'");
		// $command = mysqli_fetch_object($res, "Command", [$this->db]);
		// return $command;
		$request = $this->db->prepare("SELECT * FROM command WHERE id_user=?");
		// $request->execute([$id]);
		// $command = $request->fetchAll("Command",[$this->db]);
		// return $command;
		$request->execute([$id_user->getId()]);
		// while($order = mysqli_fetch_object($res, "Orders", [$this->db]))
		// {
		// 	$list[] = $order;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Command", [$this->db]);
		return $list;
		
	}

	public function findByStatus($status)
	{
		// $list = [];
		// $status = mysqli_real_escape_string($this->db, $status);
		// $res = mysqli_query($this->db, "SELECT * FROM orders WHERE status='".$status."'");
		$request = $this->db->prepare("SELECT * FROM command WHERE status=?");
		$request->execute([$status]);
		// while($order = mysqli_fetch_object($res, "Orders", [$this->db]))
		// {
		// 	$list[] = $order;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Orders", [$this->db]);
		return $list;
	}
	
	public function findCartByUser(User $user)
	{
		// $id_user = intval($user->getId());
		// $res = mysqli_query($this->db, "SELECT * FROM command WHERE id_user='".$id_user."' AND status='Panier' LIMIT 1");
		// $command = mysqli_fetch_object($res, "Command", [$this->db]);
		// return $command;
		$request = $this->db->prepare("SELECT * FROM command WHERE id_user=? AND status='Panier'");
		$request->execute([$user->getId()]);
		$cart = $request->fetchObject("Command", [$this->db]);
		return $cart;
	}


	// UPDATE
	public function save(Command $command)
	{
		// var_dump($command);
		// $id = intval($command->getId());
		// $products = $command->getProducts();
		// $productManager = new ProductManager($this->db);
		// mysqli_query($this->db, "DELETE FROM link_command_products WHERE id_command='".$id."'");
		// $count = 0;
		// while ($count < count($products))
		// {
		// 	$product = $products[$count];
		// 	mysqli_query($this->db, "INSERT INTO link_command_products (id_command, id_products) VALUES('".$id."', '".$products[$count]->getId()."')");
		// 	$product->setStock($product->getStock() - 1);
		// 	$productManager->save($product);
		// 	$count++;
		// }
		// //
		// $id_user = intval($command->getUser()->getId());
		// $status = mysqli_real_escape_string($this->db, $command->getStatus());
		// $total_price = floatval($command->getTotalPrice());
		// $res = mysqli_query($this->db, "UPDATE command SET status='".$status."', id_user='".$id_user."',total_price='".$total_price."' WHERE id='".$id."' LIMIT 1");
		// if (!$res)
		// {
		// 	throw new Exceptions(["Erreur interne"]);
		// }
		// return $this->findById($id);

		$id = intval($command->getId());
		$products = $command->getProducts();
		

		$productManager = new ProductManager($this->db);
		$old_list = $productManager->findNbrByCommand($command);
// 		var_dump($old_list);		
// die();
		foreach ($old_list AS $product)
		{
			$product->setStock($product->getStock() + $product->nbr);
			$productManager->save($product);
		}
		// mysqli_query($this->db, "DELETE FROM link_command_products WHERE id_command='".$id."'");
		$request = $this->db->prepare("DELETE FROM link_command_products WHERE id_command=?");
		$request->execute([$id]);
		$request = $this->db->prepare("INSERT INTO link_command_products (id_command, id_products) VALUES(?, ?)");
		$count = 0;
		while ($count < count($products))
		{
			$product = $products[$count];
			// mysqli_query($this->db, "INSERT INTO link_orders_products (id_orders, id_products) VALUES('".$id."', '".$product->getId()."')");
			$request->execute([$id, $product->getId()]);
			$product->setStock($product->getStock() - 1);
			$productManager->save($product);
			$count++;
		}
		// $id_users = intval($orders->getUser()->getId());
		// $status = mysqli_real_escape_string($this->db, $orders->getStatus());
		// $price = floatval($orders->getPrice());
		// $date = mysqli_real_escape_string($this->db, $orders->getDate());
		// mysqli_query($this->db, "UPDATE orders SET id_users='".$id_users."', status='".$status."', price='".$price."', date='".$date."' WHERE id='".$id."'");
		$request = $this->db->prepare("UPDATE command SET id_user=?, status=?, total_price=? WHERE id=?");
		
	$request->execute([$command->getUser()->getId(), $command->getStatus(), $command->getTotalPrice(), $id]);
		return $this->findById($id);
	}

	
	// DELETE
	public function remove(Command $command)
	{
		// $id = intval($command->getId());
		// mysqli_query($this->db, "DELETE from command WHERE id='".$id."' LIMIT 1");
		// return $command;
		$request = $this->db->prepare("DELETE from command WHERE id=? LIMIT 1");
		$request->execute([$command->getId()]);
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

		
		// $id_user = intval($command->getUser()->getId());
		// $res =mysqli_query($this->db, "INSERT INTO command (id_user) VALUES('".$id_user."')");
		// if (!$res)
		// {
		// 	throw new Exceptions(["Erreur interne"]);
		// }
		// $id = mysqli_insert_id($this->db);
		// return $this->findById($id);
		$request = $this->db->prepare("INSERT INTO command (id_user) VALUES(?)");
		$res = $request->execute([$command->getUser()->getId()]);
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		// $id = mysqli_insert_id($this->db);
		$id = $this->db->lastInsertId();
		return $this->findById($id);
	}
}
?>