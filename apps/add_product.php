<?php
if (isset($_SESSION['id']) && ($product->stock > 0))
{
	require('views/add_product.phtml');
}

?>