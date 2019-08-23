<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SupportImageRepository")
 */
class SupportImage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"imageInit"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"imageInit"})
     */
    private $type;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"imageInit"})
     */
    private $priceStart;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\DimensionFormatImage", mappedBy="supportImage")
     * @Groups({"imageInit"})
     */
    private $formats;

    public function __construct()
    {
        $this->formats = new ArrayCollection();
    }


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

    /**
     * @return Collection|DimensionFormatImage[]
     */
    public function getFormats(): Collection
    {
        return $this->formats;
    }

    public function addFormat(DimensionFormatImage $format): self
    {
        if (!$this->formats->contains($format)) {
            $this->formats[] = $format;
            $format->setSupportImage($this);
        }

        return $this;
    }

    public function removeFormat(DimensionFormatImage $format): self
    {
        if ($this->formats->contains($format)) {
            $this->formats->removeElement($format);
            // set the owning side to null (unless already changed)
            if ($format->getSupportImage() === $this) {
                $format->setSupportImage(null);
            }
        }

        return $this;
    }
    
}
