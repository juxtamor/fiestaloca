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
            if ($quantity <= 0)
            {
                $errors[] = 'Sold out';
            }
            else
            {
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
                    header('Location: index.php?page=cart');
                    exit;
                }
                catch (Exceptions $e)
                {
                    $errors = $e->getErrors();
                }
            }
        }
    }
    if ($action == "create")
    {
        if (isset($_SESSION['id']))
        {
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
    if ($action == "delete")
    {
        if (isset($_POST['id_product'], $_SESSION['id']))
            {
            $manager = new OrdersManager($db);
            $productsManager = new ProductsManager($db);
            $userManager = new UserManager($db);
            $product = $productsManager->findById($_POST['id_product']);
            $user = $userManager->findById($_SESSION['id']);
            $cart = $user->getCart();
            try
            {
                $cart->removeProduct($product);
                $manager->save($cart);
                header('Location: index.php?page=cart');
                exit;
            }
            catch (Exceptions $e)
            {
                $errors = $e->getErrors();
            }
        }
    }
    if ($action == "edit")
    {
        if (isset($_POST['id_command'],$_POST['id_products']))
        {
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
    if ($action == "v_order")
    {
        if (isset($_SESSION['id']))
        {
            $manager = new OrdersManager($db);
            $userManager = new UserManager($db);
            $user = $userManager->findById($_SESSION['id']);
                
            try
            {
                $cart = $user->getCart();
                $cart->setStatus("termine");
                $manager->save($cart);
                header('Location: index.php?page=orders');
                exit;
            }
            catch (Exceptions $e)
            {
                $errors = $e->getErrors();
            }
        }
    }
}
?>