<?php
class ArticleManager
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
		$res = mysqli_query($this->db, "SELECT * FROM articles ORDER BY date DESC");
		while ($article = mysqli_fetch_object($res, "Article", [$this->db]))
		{
			$list[] = $article;
		}
		return $list;
	}
	public function findById($id)
	{
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$id = intval($id);
		// /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM articles WHERE id='".$id."' LIMIT 1");
		$article = mysqli_fetch_object($res, "Article", [$this->db]); // $article = new Article();
		return $article;
	}

	public function findByIdAuthor($id_author)
	{
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\ SECURITE
		$id_author = mysqli_real_escape_string($this->db, $id_author);
		// /!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\/!\ /!\ /!\ /!\ /!\
		$res = mysqli_query($this->db, "SELECT * FROM articles WHERE id_author='".$id_author."' LIMIT 1");
		$article = mysqli_fetch_object($res, "Article", [$this->db]);
		return $article;
		
	}
	
	// UPDATE
	public function save(Article $article)
	{
		$id = intval($article->getId());
		//			
		$title = mysqli_real_escape_string($this->db, $article->getArticle());
		$article = mysqli_real_escape_string($this->db, $article->getTitle());
		$id_author = intval($article->getAuthor()->getId());
		mysqli_query($this->db, "UPDATE articles SET title='".$title."', article='".$article."', id_author='".$id_author."' WHERE id='".$id."'LIMIT 1");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		return $this->findById($id);
	}
	
	// DELETE
	public function remove(Article $article)
	{
		$id = intval($article->getId());
		mysqli_query($this->db, "DELETE from articles WHERE id='".$id."' LIMIT 1");
		return $article;
	}
	
	// INSERT
	public function create($title, $article, User $author)
	{
		$errors = [];
		$objarticle = new Article($this->db);
		$error = $objarticle->setTitle($title);// return
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $objarticle->setArticle($article);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $objarticle->setAuthor($author);
		if ($error)
		{
			$errors[] = $error;
		}
		if (count($errors) != 0)
		{
			throw new Exceptions($errors);
		}

		$article = mysqli_real_escape_string($this->db, $objarticle->getArticle());
		$title = mysqli_real_escape_string($this->db, $objarticle->getTitle());
		$id_author = intval($objarticle->getAuthor()->getId());
		$res =mysqli_query($this->db, "INSERT INTO articles (title, id_author, article) VALUES('".$title."', '".$id_author."', '".$article."')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		$id = mysqli_insert_id($this->db);
		return $this->findById($id);
	}
}
?>