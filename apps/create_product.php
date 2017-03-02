<?php
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1)
{
require('views/create_product.phtml');
}
?>