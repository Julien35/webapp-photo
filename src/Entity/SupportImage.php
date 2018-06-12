<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SupportImageRepository")
 */
class SupportImage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $priceStart;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\DimensionFormatImage", inversedBy="supportImages")
     */
    private $formats;


    public function getId()
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getPriceStart(): ?float
    {
        return $this->priceStart;
    }

    public function setPriceStart(?float $priceStart): self
    {
        $this->priceStart = $priceStart;

        return $this;
    }

    public function getFormats(): ?DimensionFormatImage
    {
        return $this->formats;
    }

    public function setFormats(?DimensionFormatImage $formats): self
    {
        $this->formats = $formats;

        return $this;
    }
}
