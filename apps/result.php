<?php  

if(isset($_GET['recherche'], $_GET["mot"])) 
{   
  $recherche = mysqli_real_escape_string($db, $_GET["mot"]);
  $res= mysqli_query($db, "SELECT * FROM products WHERE prod_name COLLATE utf8_unicode_ci LIKE '%".$recherche."%'");
  $vide = true;
  while($product = mysqli_fetch_object($res, 'Product', [$db])) 
  {  
  	$vide = false;
    require ("views/result.phtml");
  } 

   if ($vide) 
   {
  	$errors[]="Ce produit n'existe pas";
	require('views/errors.phtml');
  	}

}
?>
