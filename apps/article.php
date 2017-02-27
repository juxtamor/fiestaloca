<?php
if(isset($_GET['id']))
{
	$manager = new ArticleManager($db);
	$article = $manager->findById($_GET['id']);
	// $id = intval($_GET['id']);
	// $res = mysqli_query($db, "SELECT articles.*,users.login FROM  articles , users WHERE users.id=articles.id_author AND articles.id=".$id);
	// $article = mysqli_fetch_assoc($res);
	if($article)
	{
		
		require('views/article.phtml');
	}
	else
	{
		$errors[]="L'article n'existe pas";
		require('apps/errors.php');
	}
}
else
{
	$errors[]="L'article n'existe pas";
	require('apps/errors.php');
}
?>