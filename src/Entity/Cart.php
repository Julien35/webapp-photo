<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CartRepository")
 */
class Cart
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"cart"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"cart"})
     */
    private $dateCreation;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Registration", cascade={"persist", "remove"})
     */
    private $registration;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="cart")
     * @Groups({"cart"})
     */
    private $products;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"cart"})
     */
    private $prixTotalHt;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"cart"})
     */
    private $prixTotalTtc;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"cart"})
     */
    private $paid;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"cart"})
     */
    private $printed;


    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
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
            $product->setCart($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): self
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            // set the owning side to null (unless already changed)
            if ($product->getCart() === $this) {
                $product->setCart(null);
            }
        }

        return $this;
    }

    public function getPrixTotalHt(): ?float
    {
        return $this->prixTotalHt;
    }

    public function setPrixTotalHt(?float $prixTotalHt): self
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

    public function getPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): self
    {
        $this->paid = $paid;

        return $this;
    }

    public function getPrinted(): ?bool
    {
        return $this->printed;
    }

    public function setPrinted(bool $printed): self
    {
        $this->printed = $printed;

        return $this;
    }
}
