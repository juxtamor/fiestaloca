<?php
if (isset($_GET['id_category']))
{
        $categorieManager = new CategorieManager($db);
        $category = $categorieManager->findById($_GET['id_category']);
        $manager = new ProductManager($db);
        $list = $manager->findByCategory($category);
        $count = 0;
        while ($count < count($list))// list.length
        {
                $product = $list[$count];
                require('views/products.phtml');
                $count++;
        }
}
else
        echo "Erreur interne...";
?>