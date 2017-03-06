<?php
class Command
{
	// liste des propriétés -> privées
	private $id;
	private $status;
	private $id_user;
	private $total_price;

	//PROPRIETES CALCULEE
	private $user;
	private $products;

	//PROPRIETE TRANSMISE
	private $db;
	
	public function __construct($db)
	{
		$this->db = $db;
	}
	

	public function getId()
	{
		return $this->id;
	}

	public function getProducts()
	{
		if ($this->products === null)
		{
		$manager = new ProductManager($this->db);
		$this->products = $manager->findByCommand($this);
		}
		return $this->products;
	}
	public function addProduct(Product $product)
	{
		if ($this->products === null)
		{
			$this->getProducts();
		}
		$this->products[] = $product;
		$this->total_price += $product->getPrice();
	}
	public function editProduct(Product $product, $quantity)
	{
		$quantity = intval($quantity);
		if ($quantity <= 0)
		{
			$this->removeProduct($product);
		}
		else
		{
			if ($this->products === null)
			{
				$this->getProducts();
			}
			$stock = 0;
			foreach ($this->products AS $product_in)
			{
				if ($product_in->getId() == $product->getId())
				{
					$stock++;
				}
			}
			if ($stock < $quantity)
			{
				while ($stock < $quantity)
				{
					$this->addProduct($product);
					$stock++;
				}
			}
			else if ($stock > $quantity)
			{
				while ($stock > $quantity)
				{
					$this->removeOneProduct($product);
					$stock--;
				}
			}
		}
	}
	public function removeOneProduct(Product $product)
	{
		if ($this->products === null)
		{
			$this->getProducts();
		}
		$already = false;
		$list = [];
		foreach ($this->products AS $product_in)
		{
			if ($product_in->getId() == $product->getId() && $already == false)
			{
				$this->price -= $product_in->getPrice();
				$already = true;
			}
			else
			{
				$list[] = $product_in;
			}
		}
		$this->products = $list;
	}
	public function removeProduct(Product $product)
	{
		if ($this->products === null)
		{
			$this->getProducts();
		}
		$list = [];
		foreach ($this->products AS $product_in)
		{
			if ($product_in->getId() == $product->getId())
			{
				// modifier le prix
				$this->total_price -= $product_in->getTotalPrice();
				// modifier les stocks
				// $product_in->setQuantity($product_in->getQuantity() + 1);
			}
			else
			{
				$list[] = $product_in;
			}
		}
		$this->products = $list;
	}

	public function getStatus()
	{
		return $this->status;
	}
	public function setStatus($status)
	{
		if($status="Panier" || $status="Traitement en cours" || $status="Envoyée")
		{
				$this->status = $status;
		}		
	}

	public function getUser()
	{
		$manager = new UserManager($this->db);
		$this->user = $manager->findById($this->id_user);
		return $this->user;
	}
	public function setUser(User $user)
	{
		$this->user = $user;
		$this->id_user = $user->getId();
	}

	public function getTotalPrice()
	{
		return $this->total_price;
	}
	public function setTotalPrice($total_price)
	{
		if ($total_price<0)
		{
			return "Le prix ne peut pas être négatif";
		}
		else
		{
			$this->total_price = $total_price;
		}
	}

}
?>