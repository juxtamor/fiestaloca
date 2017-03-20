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
		// $list = [];
		$res = $this->db->query("SELECT * FROM categorie ORDER BY cat_name");//PD
		// $res = mysqli_query($this->db, "SELECT * FROM categorie ORDER BY cat_name");
		// while ($categorie = mysqli_fetch_object($res, "Categorie", [$this->db]))
		// {
		// 	$list[] = $categorie;
		// }
		$list = $res->fetchAll(PDO::FETCH_CLASS, "Categorie", [$this->db]);
		return $list;
	}

	public function findById($id)
	{
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		// $id = intval($id);
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$request = $this->db->prepare("SELECT * FROM categorie WHERE id=? LIMIT 1");//PDO
		$request->execute([$id]);
		// $res = mysqli_query($this->db, "SELECT * FROM categorie WHERE id='".$id."' LIMIT 1");
		$categorie = $request->fetchObject("Categorie", [$this->db]);
		return $categorie;
	}
	public function search($search)
	{
		
		$request = $this->db->prepare("SELECT * FROM categorie WHERE cat_name LIKE ? OR cat_desc LIKE ?");
		$request->execute(['%'.$recherche.'%', '%'.$recherche.'%']);
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Categorie", [$this->db]);
		return $list;
	}

	
	// UPDATE
	public function save(Categorie $categorie)
	{
		// $id = intval($categorie->getId());
		// //			
		// $cat_name = mysqli_real_escape_string($this->db, $cat_name->getCatName());
		// $cat_desc = mysqli_real_escape_string($this->db, $cat_desc->getCatDesc());
		// mysqli_query($this->db, "UPDATE categorie SET cat_name='".$cat_name."', cat_desc='".$cat_desc."' WHERE id='".$id."'LIMIT 1");
		$request = $this->db->prepare("UPDATE categorie SET cat_name=?, cat_desc=? WHERE id=? LIMIT 1");
		$res = $request->execute([$categorie->getCatName(), $categorie->getCatDesc(), $categorie->getId()]);
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		return $this->findById($categorie->getId());
	}

	
	// DELETE
	public function remove(Categorie $categorie)
	{
		// $id = intval($categorie->getId());
		// mysqli_query($this->db, "DELETE from categorie WHERE id='".$id."' LIMIT 1");
		$request = $this->db->prepare("DELETE from categorie WHERE id=? LIMIT 1");
		$request->execute([$categorie->getId()]);
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
		//  Comme ca ou $request = $this->db->prepare("INSERT INTO categorie (cat_name, cat_desc) VALUES(:cat_name, :$cat_desc)");
		$request = $this->db->prepare("INSERT INTO categories (cat_name,cat_desc) VALUES(?, ?)");
		$res = $request->execute([$categorie->getCatName(), $categorie->getCatDesc()]);		// $cat_name = mysqli_real_escape_string($this->db, $categorie->getCatName());
		// $cat_desc = mysqli_real_escape_string($this->db, $categorie->getCatDesc());
		// $res = mysqli_query($this->db, "INSERT INTO categorie (cat_name, cat_desc) VALUES('".$cat_name."', '".$cat_desc."')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne", mysqli_error($this->db)]);
		}
		// $id = mysqli_insert_id($this->db);// last_insert_id
		$id = $this->db->lastInsertId();
		return $this->findById($id);
	}
}
?>