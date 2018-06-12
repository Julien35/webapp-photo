<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DimensionFormatImageRepository")
 */
class DimensionFormatImage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $width;

    /**
     * @ORM\Column(type="float")
     */
    private $height;

    /**
     * @ORM\Column(type="boolean")
     */
    private $square;

    /**
     * @ORM\Column(type="boolean")
     */
    private $rectangle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SupportImage", mappedBy="formats")
     */
    private $supportImages;


    public function __construct()
    {
        $this->supportImages = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(float $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(float $height): self
    {
        $this->height = $height;

        return $this;
    }

    public function getSquare(): ?bool
    {
        return $this->square;
    }

    public function setSquare(bool $square): self
    {
        $this->square = $square;

        return $this;
    }

    public function getRectangle(): ?bool
    {
        return $this->rectangle;
    }

    public function setRectangle(bool $rectangle): self
    {
        $this->rectangle = $rectangle;

        return $this;
    }

    /**
     * @return Collection|SupportImage[]
     */
    public function getSupportImages(): Collection
    {
        return $this->supportImages;
    }

    public function addSupportImage(SupportImage $supportImage): self
    {
        if (!$this->supportImages->contains($supportImage)) {
            $this->supportImages[] = $supportImage;
            $supportImage->setFormats($this);
        }

        return $this;
    }

    public function removeSupportImage(SupportImage $supportImage): self
    {
        if ($this->supportImages->contains($supportImage)) {
            $this->supportImages->removeElement($supportImage);
            // set the owning side to null (unless already changed)
            if ($supportImage->getFormats() === $this) {
                $supportImage->setFormats(null);
            }
        }

        return $this;
    }
}
