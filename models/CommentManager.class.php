<?php
class CommentManager
{
	private $db;

	public function __construct($db)
	{
		$this->db = $db;
	}
	/*
	public function findAll()
	{
		$list = [];
		$res = mysqli_query($this->db, "SELECT * FROM comments ORDER BY date");
		while ($comment = mysqli_fetch_object($res, "Comment"))
		{
			$list[] = $comment;
		}
		return $list;
	}
	*/
	public function findByArticle(Article $article)
	{
		$id_article = intval($article->getId());
		$list = [];
		$res = mysqli_query($this->db, "SELECT * FROM comments WHERE id_article='".$id_article."' ORDER BY date DESC");
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
		$id_article = intval($comment->getArticle()->getId());
		$res = mysqli_query($this->db, "UPDATE comments SET content='".$content."', id_author='".$id_author."', id_article='".$id_article."' WHERE id='".$id."' LIMIT 1");
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
	public function create($content, User $author, Article $article)
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
		$error = $comment->setArticle($article);
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
		$id_article = intval($comment->getArticle()->getId());
		$res = mysqli_query($this->db, "INSERT INTO comments (content, id_author, id_article) VALUES('".$content."', '".$id_author."', '".$id_article."')");
		if (!$res)
		{
			throw new Exceptions(["Erreur interne"]);
		}
		$id = mysqli_insert_id($this->db);
		return $this->findById($id);
	}
}
?>