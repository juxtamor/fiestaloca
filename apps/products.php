<?php
if (isset($_GET['id_category']))
{
        $categorieManager = new CategorieManager($db);
        $category = $categorieManager->findById($_GET['id_category']);
        $list = $category->getProducts();
		require('views/products.phtml');        
}
else
{
	$manager = new ProductManager($db);
	$list = $manager->findAll();
	require('views/products.phtml');
}
?>