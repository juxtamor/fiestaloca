<?php
class Product
{
	// liste des propriétés -> privées
	private $id;
	private $prod_name;
	private $prod_desc;
	private $price;
	private $image;
	private $stock;
	private $prod_cover;
	//PROPRIETES CALCULEE
	private $id_category;

	//PROPRIETE TRANSMISE
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function getId()
	{
		return $this->id;
	}

	public function getProdName()
	{
		return $this->prod_name;
	}
	public function setProdName($prod_name)
	{
		if (strlen($prod_name) > 31)
		{
			return "Titre trop long (> 31)";
			// throw new Exception("Titre trop long (> 63)");
		}
		else if (strlen($prod_name) < 5)
		{
			return "Titre trop court (< 5)";
			// throw new Exception("Titre trop court (< 5)");
		}
		else
		{
			$this->prod_name = $prod_name;
		}
	}

	public function getProdDesc()
	{
		return $this->product;
	}
	public function setProduct($product)
	{
		if (strlen($product) > 4095)
		{
			return "Contenu trop long (> 4095)";
		}
		else if (strlen($product) < 65)
		{
			return "Contenu trop court (< 65)";
		}
		else
		{
			$this->product = $product;
		}
	}

	public function getPrice()
	{
		return $this->price;
	}
	public function setPrice($price)
	{	
		return	$this->price = $price;
	}

	public function getImage()
	{
		return $this->image;
	}
	public function setImage($image)
	{
		if (strlen($image) > 255)
		{
			return "Contenu trop long (> 255)";
		}
		else if (strlen($image) < 10)
		{
			return "Contenu trop court (< 10)";
		}
		else
		{
			$this->image = $image;
		}
	}

	public function getStock()
	{
		return $this->stock;
	}
	public function setStock($stock)
	{
		if (strlen($stock) > 255)
		{
			return "Contenu trop long (> 255)";
		}
		else if (strlen($stock) < 10)
		{
			return "Contenu trop court (< 10)";
		}
		else
		{
			$this->stock = $stock;
		}
	}

	public function setProdCover($prod_cover)
	{
		if (strlen($prod_cover) > 255)
		{
			return "Contenu trop long (> 255)";
		}
		else if (strlen($prod_cover) < 10)
		{
			return "Contenu trop court (< 10)";
		}
		else
		{
			$this->prod_cover = $prod_cover;
		}
	}

	public function getComments()
	{
		$manager = new CommentManager($this->db);
		$this->comments = $manager->findByProduct($this);
		return $this->comment;// null
	}

	public function getDate()
	{
		return $this->date;
	}


	public function getIdCategory()
	{
		$manager = new CategoryManager($this->db);
		$this->category = $manager->findById($this->id_category);
		return $this->category;
	}
	public function setIdCategory(Category $id_category)
	{
		// $this->id_category = $id_category;
		$this->id_author = $id_category->getId();
	}
}
?>