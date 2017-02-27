<?php
class Comment
{
	// liste des propriétés -> privées

	//PROPRIETES STOCKEES
	private $id;
	private $date;
	private $content;
	private $id_author;
	private $id_article;

	//PROPRIETES CALCULEE
	private $author;
	private $article;

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
	
	
	public function getDate()
	{
		return $this->date;
	}

	
	public function getContent()
	{
		return $this->content;
	}
	public function setContent($content)
	{
		if (strlen($content) < 3)
		{
			return "Contenu trop court (< 3)";
		}
		else if (strlen($content) > 2047)
		{
			return "Contenu trop long (> 4095)";
		}
		else
		{
			$this->content = $content;
		}
	}
	// public function getIdAuthor()
	// {
	// 	return $this->id_author;
	// }
	// public function setIdAuthor($id_author)
	// {
	// 	if (($id_author))
	// 	{
	// 		$this->id_author = $id_author;
	// 	}
	// }
	public function getArticle()
	{
		$manager = new ArticleManager($this->db);
		$this->article = $manager->findById($this->id_article);
		return $this->article;
	}
	public function setArticle(Article $article)
	{
		$this->article = $article;
		$this->id_article = $article->getId();	
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