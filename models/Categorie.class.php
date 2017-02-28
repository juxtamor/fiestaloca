<?php
class Categorie
{
	// liste des propriétés -> privées

	//PROPRIETES STOCKEES
	private $id;
	private $cat_name;
	private $cat_desc;


	//PROPRIETES CALCULEE
	private $products;


	//PROPRIETE TRANSMISE
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}


	// GET
	public function getId()
	{
		return $this->id;
	}

	public function getCatName()
	{
		return $this->cat_name;
	}

	public function getCatDesc()
	{
		return $this->cat_desc;
	}
	public function getProducts()
	{
		return $this->products;
	}


	// SET
	public function setCatName($cat_name)
	{
		if (strlen($cat_name) > 31)
		{
			return "Catégorie trop long (> 31)";
		}
		else if (strlen($cat_name) < 3)
		{
			return "Catégorie trop court (< 3)";
		}
		else
		{
			$this->cat_name = $cat_name;
		}
	}

	public function setCatDesc($cat_desc)
	{
		if (strlen($cat_desc) > 4095)
		{
			return "Description trop long (> 4095)";
		}
		else if (strlen($cat_desc) < 3)
		{
			return "Description trop court (< 8)";
		}
		else
		{
			$this->cat_desc = $cat_desc;
		}
	}
}
?>