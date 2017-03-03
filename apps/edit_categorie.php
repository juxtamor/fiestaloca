<?php
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1)
{
require('views/edit_categorie.phtml');
}
?>