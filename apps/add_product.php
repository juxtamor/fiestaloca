<?php
if (isset($_SESSION['id']) && ($product->getStock() > 0))
{
	require('views/add_product.phtml');
}

?>