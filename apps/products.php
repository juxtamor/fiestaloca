<?php
if (isset($_GET['id_category']))
{
        $categorieManager = new CategorieManager($db);
        $category = $categorieManager->findById($_GET['id_category']);
        if ($category)
        {
	        $list = $category->getProducts();
			require('views/products.phtml');
        }

		else
		{
			$errors[]="Ce produit n'existe pas";
			require('views/errors.phtml');
		}
}
else
{
	$manager = new ProductManager($db);
	$list = $manager->findAll();
	require('views/all_products.phtml');
}

?>