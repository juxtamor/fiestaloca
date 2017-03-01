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

	//PROPRIETE TRANSMISE
	private $db;
	

	public function getId()
	{
		return $this->id;
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