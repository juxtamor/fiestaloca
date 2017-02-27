<?php
class Article
{
	// liste des propriétés -> privées
	private $id;
	private $title;
	private $article;
	private $date;
	private $id_author;
  
	//PROPRIETES CALCULEE
	private $author;

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

	public function getTitle()
	{
		return $this->title;
	}
	public function setTitle($title)
	{
		if (strlen($title) > 63)
		{
			return "Titre trop long (> 63)";
			// throw new Exception("Titre trop long (> 63)");
		}
		else if (strlen($title) < 5)
		{
			return "Titre trop court (< 5)";
			// throw new Exception("Titre trop court (< 5)");
		}
		else
		{
			$this->title = $title;
		}
	}

	public function getArticle()
	{
		return $this->article;
	}
	public function setArticle($article)
	{
		if (strlen($article) > 4095)
		{
			return "Contenu trop long (> 4095)";
		}
		else if (strlen($article) < 65)
		{
			return "Contenu trop court (< 65)";
		}
		else
		{
			$this->article = $article;
		}
	}

	public function getComments()
	{
		$manager = new CommentManager($this->db);
		$this->comments = $manager->findByArticle($this);
		return $this->comment;// null
	}

	public function getDate()
	{
		return $this->date;
	}


	public function getAuthor()
	{
		$manager = new UserManager($this->db);
		$this->author = $manager->findById($this->id_author);
		return $this->author;
	}
	public function setAuthor(User $author)
	{
		$this->author = $author;
		$this->id_author = $author->getId();
	}
}
?>