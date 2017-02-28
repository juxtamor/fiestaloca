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
	private $id_category;
	

	private $category;
	private $comments;

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
	public function getProdCover()
	{
		return $this->prod_cover;
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
		return $this->prod_desc;
	}
	public function setProdDesc($prod_desc)
	{
		if (strlen($prod_desc) > 4095)
		{
			return "Contenu trop long (> 4095)";
		}
		else if (strlen($prod_desc) < 65)
		{
			return "Contenu trop court (< 65)";
		}
		else
		{
			$this->prod_desc = $prod_desc;
		}
	}

	public function getPrice()
	{
		return $this->price;
	}
	public function setPrice($price)
	{	
		if ($price < 0)
		{
			return "Le prix ne peut être negatif";
		}
	else
		{
			$this->price = $price;
		}
	}

	public function getImage()
	{
		return $this->image;
	}
	public function setImage($image)
	{
		if (strlen($image)<10)
		{
			return "L'url de l'image est trop court (<10)";
		}
		else if (strlen($image)>511)
		{
			return "L'url de l'image est trop long (>255)";
		}
		else if (filter_var($image, FILTER_VALIDATE_URL) == false) 
		{
			return "L'url n'est pas valide";
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
		if (strlen($stock) < 0)
		{
			return "Le stock ne peut pas être negatif";
		}
		
		else
		{
			$this->stock = $stock;
		}
	}

	public function setProdCover($prod_cover)
	{
		if (strlen($prod_cover)<10)
		{
			return "L'url de l'image est trop court (<10)";
		}
		else if (strlen($prod_cover)>255)
		{
			return "L'url de l'image est trop long (>255)";
		}
		else if (filter_var($prod_cover, FILTER_VALIDATE_URL) == false) 
		{
			return "L'url n'est pas valide";
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
		return $this->comments;// null
	}

	public function getDate()
	{
		return $this->date;
	}


	public function getCategory()
	{
		$manager = new CategorieManager($this->db);
		$this->category = $manager->findById($this->id_category);
		return $this->category;
	}
	public function setCategory(Categorie $category)
	{
		// $this->id_category = $id_category;
		$this->category = $category;
		$this->id_category = $category->getId();
	}
}
?>