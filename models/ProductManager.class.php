<?php
class ProductManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function search($search)
	{
		// $list = [];
		// $recherche = mysqli_real_escape_string($this->db, $search);
		// $res = mysqli_query($this->db, "SELECT * FROM products WHERE name LIKE '%".$recherche."%' OR description LIKE '%".$recherche."%'");
		$request = $this->db->prepare("SELECT * FROM products WHERE name LIKE ? OR prod_desc LIKE ?");
		$request->execute(['%'.$search.'%', '%'.$search.'%']);
		// while($product = mysqli_fetch_object($res, "Products", [$this->db]))
		// {
		// 	$list[] = $product;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Products", [$this->db]);
		return $list;
	}


	// SELECT
	public function findByCommand(Command $command)
	{
		// $id = intval($command->getId());
		// $list = [];
		// $res = mysqli_query($this->db, "SELECT products.* FROM products LEFT JOIN link_command_products ON link_command_products.id_products=products.id WHERE link_command_products.id_command='".$id."'");
		// while ($product = mysqli_fetch_object($res, "Product", [$this->db]))
		// {
		// 	$list[] = $product;
		// }
		// return $list;
		$request = $this->db->prepare("SELECT products.* FROM products LEFT JOIN link_command_products ON link_command_products.id_products=products.id WHERE link_command_products.id_command=?");
		$request->execute([$command->getId()]);
		// while($products = mysqli_fetch_object($res, "Products", [$this->db]))
		// {
		// 	$list[] = $products;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Product", [$this->db]);
		return $list;
	}

	public function findAll()
	{
		// $list = [];
		// $res = mysqli_query($this->db, "SELECT * FROM products ORDER BY prod_name");
		// while ($product = mysqli_fetch_object($res, "Product", [$this->db]))
		// {
		// 	$list[] = $product;
		// }
		// return $list;
		$request = $this->db->query("SELECT * FROM products ORDER BY prod_name");
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Product", [$this->db]);
		return $list;
	}
	public function findById($id)
	{
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		// $id = intval($id);
		// // /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		// $res = mysqli_query($this->db, "SELECT * FROM products WHERE id='".$id."' LIMIT 1");
		// $product = mysqli_fetch_object($res, "Product", [$this->db]); // $article = new Article();
		// return $product;
		$request = $this->db->prepare("SELECT * FROM products WHERE id=? ORDER BY prod_name");
		$request->execute([$id]);
		// $products = mysqli_fetch_object($res, "Products", [$this->db]); 
		// $user = new User();
		$products = $request->fetchObject("Product", [$this->db]);
		return $products;
	}
	public function findNbrByCommand(Command $command)
	{
		// $id = intval($order->getId());
		// $list = [];
		// $res = mysqli_query($this->db, "SELECT products.*, COUNT(products.id) AS nbr FROM products LEFT JOIN link_orders_products ON link_orders_products.id_products=products.id WHERE link_orders_products.id_orders='".$id."' GROUP BY products.id");
		$request = $this->db->prepare("SELECT products.*, COUNT(products.id) AS nbr FROM products LEFT JOIN link_command_products ON link_command_products.id_products=products.id WHERE link_command_products.id_command=? GROUP BY products.id");
		$request->execute([$command->getId()]);
		// while($products = mysqli_fetch_object($res, "Products", [$this->db]))
		// {
		// 	$list[] = $products;
		// }
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Product", [$this->db]);
		return $list;
	}


	public function findByCategory(Categorie $category)
	{
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\ SECURITE
		// $id_category = intval($category-> getId());
		// $list = [];
		// // /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\
		// $res = mysqli_query($this->db, "SELECT * FROM products WHERE id_category='".$id_category."'");
		// while($product = mysqli_fetch_object($res, "Product", [$this->db]))
		// {
		// 	$list[] = $product;
		// }
		// return $list;
		$request = $this->db->prepare("SELECT * FROM products WHERE id_category=?");
		$request->execute([$category->getId()]);
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Product", [$this->db]);
		return $list;
	}
	
	// UPDATE
	public function save(Product $product)
	{
		// $id = intval($product->getId());
		// $id_category = intval($product->getCategory()->getId());
		// $prod_name = mysqli_real_escape_string($this->db, $product->getProdName());
		// $prod_desc = mysqli_real_escape_string($this->db, $product->getProdDesc());
		// $price = floatval($product->getPrice());
		// $stock =intval($product->getStock());
		// $res = mysqli_query($this->db, "UPDATE products SET prod_name='".$prod_name."', prod_desc='".$prod_desc."', stock='".$stock."', price='".$price."', id_category='".$id_category."' WHERE id='".$id."'LIMIT 1");
		// if (!$res)
		// {
		// 	throw new Exceptions(["Erreur interne"]);
		// }
		// return $this->findById($id);
		$request = $this->db->prepare("UPDATE products SET prod_name=?, prod_desc=?, stock=?, price=?, id_category=? WHERE id=? LIMIT 1");
		$request->execute([$product->getId(), $product->getProdName(), $product->getProdDesc(), $product->getStock(), $product->getPrice(), $product->getCategory()->getId()]);
		return $this->findById($product->getId());
	}
	
	// DELETE
	public function remove(Product $product)
	{
		// $id = intval($product->getId());
		// mysqli_query($this->db, "DELETE from products WHERE id='".$id."' LIMIT 1");
		// return $product;
		$request = $this->db->prepare("DELETE from products WHERE id=? LIMIT 1");
		$request->execute([$products->getId()]);
		return $products;
	}
	
	// INSERT
	public function create($prod_name, $prod_desc, $price, $image, $stock, Categorie $category)
	{
		$errors = [];
		$product = new Product($this->db);
		$error = $product->setProdName($prod_name);// return
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $product->setProdDesc($prod_desc);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $product->setPrice($price);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $product->setImage($image);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $product->setStock($stock);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $product->setCategory($category);
		if ($error)
		{
			$errors[] = $error;
		}
		if (count($errors) != 0)
		{
			throw new Exceptions($errors);
		}

		// $product = mysqli_real_escape_string($this->db, $product->getProduct());
		// $prod_name = mysqli_real_escape_string($this->db, $product->getProdName());
		// $prod_desc = mysqli_real_escape_string($this->db, $product->getProdDesc());
		// $id_category = intval($this->db, $product->getCategory()->getId());
		// $prod_cover = mysqli_real_escape_string($this->db, $product->getProdCover());
		// // $id_category = intval($product->getCategory()->getId());
		// $res =mysqli_query($this->db, "INSERT INTO products (prod_name, prod_desc, price, image, stock, id_category, prod_cover) VALUES('".$prod_name."', '".$prod_desc."', '".$price."' , '".$image."','".$stock."','".$id_category."','".$prod_cover."')");
		// if (!$res)
		// {
		// 	throw new Exceptions(["Erreur interne"]);
		// }
		// $id = mysqli_insert_id($this->db);
		// return $this->findById($id);
		$request = $this->db->prepare("INSERT INTO products (prod_name, prod_desc, price, image, stock, id_category, prod_cover) VALUES(?, ?, ?, ?, ?, ?,?)");
		$request->execute([$products->getCategory()->getId(), $products->getProdName(),$products->getProdDesc(),$products->getPrice(), $products->getImage(), $products->getStock(), $products->getIdCategory(),$products->getProdCover()]);
		// $id = mysqli_insert_id($this->db);// last_insert_id
		$id = $this->db->lastInsertId();
		return $this->findById($id);

	}
}
?>