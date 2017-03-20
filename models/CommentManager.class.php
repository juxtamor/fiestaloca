<?php
class CommentManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}

	public function findById($id)
	{
		// $id = intval($id);
		// $res = mysqli_query($this->db, "SELECT * FROM comments WHERE id='".$id."' LIMIT 1");
		// $comment = mysqli_fetch_object($res, "Comment",[$this->db]);
		// return $comment;
		$request = $this->db->prepare("SELECT * FROM comments WHERE id=? LIMIT 1");
		$request->execute([$id]);
		$comment = $request->fetchObject("Comment",[$this->db]);
		return $ccomment;
	}
	

	public function findByProd(Product $prod)
	{
		// $id_prod = intval($prod->getId());
		// $list = [];
		// $res = mysqli_query($this->db, "SELECT * FROM comments WHERE id_prod='".$id_prod."' ORDER BY date DESC");
		// while ($comment = mysqli_fetch_object($res, "Comment",[$this->db]))
		// {
		// 	$list[] = $comment;
		// }
		// return $list;
		$request = $this->db->query("SELECT * FROM comments WHERE id_prod=? ORDER BY date DESC");
		$request->execute([$products->getId()]);
		$list = $request->fetchAll(PDO::FETCH_CLASS, "Comment", [$this->db]);
		return $list;
	}

	public function save(Comment $comment)
	{
		// $id = intval($comment->getId());
		// $content = mysqli_real_escape_string($this->db, $comment->getContent());
		// $id_author = intval($comment->getAuthor()->getId());
		// $id_article = intval($comment->getProd()->getId());
		// $res = mysqli_query($this->db, "UPDATE comments SET content='".$content."', id_author='".$id_author."', id_prod='".$id_prod."' WHERE id='".$id."' LIMIT 1");
		// if (!$res)
		// {
		// 	throw new Exceptions(["Erreur interne"]);
		// }
		// return $this->findById($id);
		$request = $this->db->prepare("UPDATE comments SET content=?, id_author=?, id_prod=? WHERE id=? LIMIT 1");
		$request = $request->execute([$comment->getContent(), $comment->getIdAuthor()->getId(), $comment->getIdProd()->getId()]);
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		// return $this->findById($id);
		return $this->findById($comment->getId());
	}

	public function remove(Comment $comment)
	{
		// $id = intval($comment->getId());
		// mysqli_query($this->db, "DELETE from comments WHERE id='".$id."' LIMIT 1");
		// return $comment;
		$request = $this->db->prepare("DELETE from comments WHERE id=? LIMIT 1");
		$request->execute([$comment->getId()]);
		return $comment;
	}

	public function create($content, User $author, Product $prod, $note)
	{
		$errors = [];
		$comment = new Comment($this->db);
		$error = $comment->setContent($content);
		if ($error)
		{
			$errors[] = $error;
		}
		$error = $comment->setNote($note);
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
		// $content = mysqli_real_escape_string($this->db, $comment->getContent());
		// $note = intval($comment->getNote());
		// $id_author = intval($comment->getAuthor()->getId());
		// $id_prod = intval($comment->getProd()->getId());
		// $res = mysqli_query($this->db, "INSERT INTO comments (content, id_author, id_prod, note) VALUES('".$content."', '".$id_author."', '".$id_prod."', '".$note."')");
		// if (!$res)
		// {
		// 	throw new Exceptions(["Erreur interne"]);
		// }
		// $id = mysqli_insert_id($this->db);
		// return $this->findById($id);
		$request = $this->db->prepare("INSERT INTO comments (content, id_author, id_prod, note) VALUES(?, ?,?,?)");
		$res = $request->execute([$comment->getContent(), $comment->getIdAuthor()->getId(), $comment->getIdProd()->getId(),$comment->getNote()]);
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		// $id = mysqli_insert_id($this->db);
		$id = $this->db->lastInsertId();
		return $this->findById($id);
	}
}
?>