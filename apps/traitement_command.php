<?php
if (isset($_POST['action']))
{
        $action = $_POST['action'];
        if ($action == "add")
        {
                if (isset($_SESSION['id'], $_POST['id_product'], $_POST['quantity']))
                {
                        $manager = new CommandManager($db);
                        $userManager = new UserManager($db);
                        $productManager = new ProductManager($db);
                        $user = $userManager->findById($_SESSION['id']);
                        $product = $productManager->findById($_POST['id_product']);
                        $quantity =intval($_POST['quantity']);

                        // if ($_POST['quantity'] > $product->getStock())
                            // YOLO
                        $cart = $user->getCart();
                        try
                        {
                            if (!$cart)
                            {
                                $cart = $manager->create($user);
                            }
                            if($product->getStock()>=$quantity)
                            {
                                $count=0;
                                while($count < $quantity)
                                {
                                $cart->addProduct($product);
                                $count++;
                                }
                            }
                            // while ($quantity)
                            $manager->save($cart);
                            $cart->addProduct($product);
                            header('Location: index.php?page=cart');
                            exit;
                        }
                        catch (Exceptions $e)
                        {
                                $errors = $e->getErrors();
                        }
                }
        }
        if ($action == "create")
        {
                // Etape 1
                if (isset($_SESSION['id']))
                {
                        // Etape 2
                        $manager = new CommandManager($db);
                        $userManager = new UserManager($db);
                        $user = $userManager->findById($_SESSION['id']);
                        try
                        {
                                $command = $manager->create($user);
                                if ($command)
                                {
                                        header('Location: index.php?page=cart');
                                        exit;
                                }
                                else
                                {
                                        $errors[] = "Erreur interne";
                                }        
                        }
                        catch (Exceptions $e)
                        {
                                $errors = $e->getErrors();
                        }
                }
        }
        if ($action == "modify")
        {
                // Etape 1
                if (isset($_POST['id_command'],$_POST['id_products']))
                {
                        // Etape 2
                        $manager = new CommandManager($db);
                        $productManager = new ProductManager($db);
                        $userManager = new UserManager($db);
                        $user = $userManager->findById($_SESSION['id']);
                        try
                        {
                                $command = $manager->modify($user);
                                if ($command)
                                {
                                        header('Location: index.php?page=cart');
                                        exit;
                                }
                                else
                                {
                                        $errors[] = "Erreur interne";
                                }        
                        }
                        catch (Exceptions $e)
                        {
                                $errors = $e->getErrors();
                        }
                }
        }
        // if ($action == "delete")
        // {
        //    array array_splice ( array &$input , int $offset [, int $length = 0 [, mixed $replacement = array() ]] ) 
        // }
}
/*
$product = $manager->findById($_POST['id_product']);
$err = $product->setProdName("nouveau nom");
if ($err)
    $errors[] = $err;
...
if (count($errors) == 0)
{
    $manager->save($product);
    header
    exit;
}
*/
?>