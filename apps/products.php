<?php
/*while ($article = mysqli_fetch_assoc($res))
{
        require('views/articles_elem.phtml');
}*/
if (isset($_GET['id_category']))
{
        $categoryManager = new CategoryManager($db);
        $category = $categoryManager->findById($_GET['id_category']);
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
        echo "taggle";
?>