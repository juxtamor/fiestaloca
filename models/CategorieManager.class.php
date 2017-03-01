<?php
class CategorieManager
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
		$res = mysqli_query($this->db, "SELECT * FROM categorie ORDER BY cat_name");
		while ($categorie = mysqli_fetch_object($res, "Categorie", [$this->db]))
		{
			$list[] = $categorie;
		}
		return $list;
	}

	public function findById($id)
	{
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$id = intval($id);
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM categorie WHERE id='".$id."' LIMIT 1");
		$categorie = mysqli_fetch_object($res, "Categorie", [$this->db]);
		return $categorie;
	}

	
	// UPDATE
	public function save(Categorie $categorie)
	{
		$id = intval($categorie->getId());
		//			
		$cat_name = mysqli_real_escape_string($this->db, $cat_name->getCatName());
		$cat_desc = mysqli_real_escape_string($this->db, $cat_desc->getCatDesc());
		mysqli_query($this->db, "UPDATE categorie SET cat_name='".$cat_name."', cat_desc='".$cat_desc."' WHERE id='".$id."'LIMIT 1");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		return $this->findById($id);
	}

	
	// DELETE
	public function remove(Categorie $categorie)
	{
		$id = intval($categorie->getId());
		mysqli_query($this->db, "DELETE from categorie WHERE id='".$id."' LIMIT 1");
		return $categorie;
	}

	
	// INSERT
	public function create($cat_name, $cat_desc)
	{
		$errors = [];
		$categorie = new Categorie($this->db);
		$error = $categorie->setCatName($cat_name);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $categorie->setCatDesc($cat_desc);
		if ($error)
		{
			$errors[] = $error;
		}
		if (count($errors) != 0)
		{
			throw new Exceptions($errors);
		}

		$cat_name = mysqli_real_escape_string($this->db, $cat_name->getCatName());
		$cat_desc = mysqli_real_escape_string($this->db, $cat_desc->getCatDesc());
		$res = mysqli_query($this->db, "INSERT INTO categorie (cat_name, cat_desc) VALUES('".$cat_name."', '".$cat_desc."')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne", mysqli_error($this->db)]);
		}
		$id = mysqli_insert_id($this->db);// last_insert_id
		return $this->findById($id);
	}
}
?>