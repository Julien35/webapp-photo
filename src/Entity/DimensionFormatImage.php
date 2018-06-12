<?php

namespace App\Entity;

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
}
