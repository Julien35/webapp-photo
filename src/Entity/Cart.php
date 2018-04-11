<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Registration", cascade={"persist", "remove"})
     */
    private $registration;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="cart_id")
     */
    private $products;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixTotalHt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $prixTotalTtc;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDateCreation(): ?DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getRegistration(): ?Registration
    {
        return $this->registration;
    }

    public function setRegistration(?Registration $registration): self
    {
        $this->registration = $registration;

        return $this;
    }

    /**
     * @return Collection|Product[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setCartId($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCartId() === $this) {
                $product->setCartId(null);
            }
        }

        return $this;
    }

    public function getprixTotalHt(): ?float
    {
        return $this->prixTotalHt;
    }

    public function setprixTotalHt(?float $prixTotalHt): self
    {
        $this->prixTotalHt = $prixTotalHt;

        return $this;
    }

    public function getPrixTotalTtc(): ?float
    {
        return $this->prixTotalTtc;
    }

    public function setPrixTotalTtc(?float $prixTotalTtc): self
    {
        $this->prixTotalTtc = $prixTotalTtc;

        return $this;
    }
}
