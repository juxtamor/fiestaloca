<?php
class Comment
{
	// liste des propriétés -> privées

	//PROPRIETES STOCKEES
	private $id;
	private $content;
	private $id_author;
	private $id_prod;
	private $note;
	private $date;

	//PROPRIETES CALCULEE
	private $author;
	private $prod;

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
	
	public function getContent()
	{
		return $this->content;
	}

	public function getAuthor()
	{
		$manager = new UserManager($this->db);
		$this->author = $manager->findById($this->id_author);
		return $this->author;
	}

	public function getProd()
	{
		$manager = new ProductManager($this->db);
		$this->prod = $manager->findById($this->id_prod);
		return $this->prod;
	}
	
	public function getNote()
	{
		return $this->note;
	}

	public function getDate()
	{
		return $this->date;
	}
	

	// SET
	public function setContent($content)
	{
		if (strlen($content) < 3)
		{
			return "Contenu trop court (< 3)";
		}
		else if (strlen($content) > 4095)
		{
			return "Contenu trop long (>4095)";
		}
		else
		{
			$this->content = $content;
		}
	}
	
	public function setAuthor(User $author)
	{
		$this->author = $author;
		$this->id_author = $author->getId();
	}

	public function setProd(Product $prod)
	{
		$this->prod = $prod;
		$this->id_prod = $prod->getId();	
	}
}
?>