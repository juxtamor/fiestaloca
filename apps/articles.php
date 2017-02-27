<?php
$manager = new ArticleManager($db);
$list = $manager->findAll();
require('views/articles.phtml');
?>