<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DimensionFormatImageRepository")
 */
class DimensionFormatImage
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"imageInit"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"imageInit"})
     */
    private $width;

    /**
     * @ORM\Column(type="float")
     * @Groups({"imageInit"})
     */
    private $height;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"imageInit"})
     */
    private $square;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"imageInit"})
     */
    private $rectangle;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\SupportImage", inversedBy="formats")
     */
    private $supportImage;


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

    public function getSupportImage(): ?SupportImage
    {
        return $this->supportImage;
    }

    public function setSupportImage(?SupportImage $supportImage): self
    {
        $this->supportImage = $supportImage;

        return $this;
    }
}
