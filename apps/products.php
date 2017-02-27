<?php
$manager = new ProductManager($db);
$list = $manager->findAll();
require('views/products.phtml');
?>