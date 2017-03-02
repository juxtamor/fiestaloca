<?php  
// if(isset($_POST['recherche'])) 
// {   
//   $recherche = $_POST["mot"];
//   $res= mysqli_query($db, "SELECT * FROM products WHERE prod_name like '%$recherche%'");
//   while($registro = mysqli_fetch_assoc($res)) 
//   {  
//     require ("views/result.phtml");
//   } 
// }
if(isset($_GET['recherche'])) 
{   
  $recherche = $_GET["mot"];
  $res= mysqli_query($db, "SELECT * FROM products WHERE prod_name like '%$recherche%'");
  while($registro = mysqli_fetch_assoc($res)) 
  {  
    require ("views/result.phtml");
  } 
}
// <?php  
// if(isset($_GET['search'])) 
// {   
//   $recherche = $_GET["search"];
//   $res= mysqli_query($db, "SELECT * FROM products WHERE prod_name like '%$recherche%' OR prod_desc like '%$recherche%'");
//   while($registro = mysqli_fetch_assoc($res)) 
//   {  
//     require ("views/result.phtml");
//   } 
// }
// 
?>
