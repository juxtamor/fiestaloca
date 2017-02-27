<?php
class CommentManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function findByProd(Product $prod)
	{
		$id_prod = intval($prod->getId());
		$list = [];
		$res = mysqli_query($this->db, "SELECT * FROM comments WHERE id_prod='".$id_prod."' ORDER BY date DESC");
		while ($comment = mysqli_fetch_object($res, "Comment",[$this->db]))
		{
			$list[] = $comment;
		}
		return $list;
	}

	public function findById($id)
	{
		$id = intval($id);
		$res = mysqli_query($this->db, "SELECT * FROM comments WHERE id='".$id."' LIMIT 1");
		$comment = mysqli_fetch_object($res, "Comment",[$this->db]);
		return $comment;
	}

	public function save(Comment $comment)
	{
		$id = intval($comment->getId());
		$content = mysqli_real_escape_string($this->db, $comment->getContent());
		$id_author = intval($comment->getAuthor()->getId());
		$id_article = intval($comment->getProd()->getId());
		$res = mysqli_query($this->db, "UPDATE comments SET content='".$content."', id_author='".$id_author."', id_prod='".$id_prod."' WHERE id='".$id."' LIMIT 1");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		return $this->findById($id);
	}

	public function remove(Comment $comment)
	{
		$id = intval($comment->getId());
		mysqli_query($this->db, "DELETE from comments WHERE id='".$id."' LIMIT 1");
		return $comment;
	}

	public function create($content, User $author, Product $prod)
	{
		$errors = [];
		$comment = new Comment($this->db);
		$error = $comment->setContent($content);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $comment->setAuthor($author);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $comment->setProd($prod);
		if ($error)
		{
			$errors[] = $error;
		}
		if (count($errors) != 0)
		{
			throw new Exceptions($errors);
		}
		$content = mysqli_real_escape_string($this->db, $comment->getContent());
		$id_author = intval($comment->getAuthor()->getId());
		$id_prod = intval($comment->getProd()->getId());
		$res = mysqli_query($this->db, "INSERT INTO comments (content, id_author, id_prod) VALUES('".$content."', '".$id_author."', '".$id_prod."')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		$id = mysqli_insert_id($this->db);
		return $this->findById($id);
	}
}
?>