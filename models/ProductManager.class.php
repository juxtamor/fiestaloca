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
		$res = mysqli_query($this->db, "SELECT * FROM products ORDER BY prod_name");
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

	public function findByCategory(Category $category)
	{
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\ SECURITE
		$id_category = intval($product-> getId());
		$list = [];
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM products WHERE id_category='".$id_category."' LIMIT 1");
		while($product = mysqli_fetch_object($res, "Product", [$this->db]))
		{
			$list[] = $product;
		}
		return $list;

	}
	
	// UPDATE
	public function save(Product $product)
	{
		$id = intval($product->getId());
		//			
		$prod_name = mysqli_real_escape_string($this->db, $product->getProdName());
		$prod_desc = mysqli_real_escape_string($this->db, $product->getProdDesc());
		$id_category = intval($this->db, $product->getIdCategory());
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

		$product = mysqli_real_escape_string($this->db, $product->getProduct());
		$prod_name = mysqli_real_escape_string($this->db, $product->getProdName());
		$prod_desc = mysqli_real_escape_string($this->db, $product->getProdName());
		$category = mysqli_real_escape_string($this->db, $product->getCategory());
		$prod_cover = mysqli_real_escape_string($this->db, $product->getProdCover());
		// $id_category = intval($product->getCategory()->getId());
		$res =mysqli_query($this->db, "INSERT INTO products (prod_name, prod_desc, price, image, stock, id_category, prod_cover) VALUES('".$prod_name."', '".$prod_desc."', '".$price."' , '".$image."','".$stock."','".$id_category."','".$prod_cover."')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		$id = mysqli_insert_id($this->db);
		return $this->findById($id);
	}
}
?>