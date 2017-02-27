<?php
class ProductManager
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
		$res = mysqli_query($this->db, "SELECT * FROM products ORDER BY date DESC");
		while ($product = mysqli_fetch_object($res, "Product", [$this->db]))
		{
			$list[] = $product;
		}
		return $list;
	}
	public function findById($id)
	{
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$id = intval($id);
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM products WHERE id='".$id."' LIMIT 1");
		$product = mysqli_fetch_object($res, "Product", [$this->db]); // $article = new Article();
		return $product;
	}

	public function findByIdCategory($id_category)
	{
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\ SECURITE
		$id_author = mysqli_real_escape_string($this->db, $id_category);
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM products WHERE id_category='".$id_category."' LIMIT 1");
		$product = mysqli_fetch_object($res, "Products", [$this->db]);
		return $product;
		
	}
	
	// UPDATE
	public function save(Product $product)
	{
		$id = intval($product->getId());
		//			
		$prod_name = mysqli_real_escape_string($this->db, $product->getProduct());
		$prod_desc = mysqli_real_escape_string($this->db, $product->getProduct());
		$id_category = intval($product->getIdCategory()->getId());
		mysqli_query($this->db, "UPDATE products SET prod_name='".$prod_name."', product='".$product."', id_category='".$id_category."' WHERE id='".$id."'LIMIT 1");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		return $this->findById($id);
	}
	
	// DELETE
	public function remove(Product $product)
	{
		$id = intval($product->getId());
		mysqli_query($this->db, "DELETE from products WHERE id='".$id."' LIMIT 1");
		return $product;
	}
	
	// INSERT
	public function create($prod_name)
	{
		$errors = [];
		$objproduct = new Product($this->db);
		$error = $objproduct->setProdName($prod_name);// return
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $objproduct->setProduct($product);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $objproduct->setProduct($product);
		if ($error)
		{
			$errors[] = $error;
		}
		if (count($errors) != 0)
		{
			throw new Exceptions($errors);
		}

		$product = mysqli_real_escape_string($this->db, $objproduct->getProduct());
		$prod_name = mysqli_real_escape_string($this->db, $objproduct->getProdName());
		$id_category = intval($objproduct->getCategory()->getId());
		$res =mysqli_query($this->db, "INSERT INTO products (prod_name, prod_desc, price, image, stock, id_category, product) VALUES('".$prod_name."', '".$id_desc."', '".$price."' , '".$image."','".$stock."','".$id_category"','".$pro_cover"')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		$id = mysqli_insert_id($this->db);
		return $this->findById($id);
	}
}
?>