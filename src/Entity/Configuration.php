<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ConfigurationRepository")
 */
class Configuration
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $imageMaxSize;

    /**
     * @ORM\Column(type="integer")
     */
    private $imageMaxNumber;

    public function getId()
    {
        return $this->id;
    }

    public function getImageMaxSize(): ?int
    {
        return $this->imageMaxSize;
    }

    public function setImageMaxSize(int $imageMaxSize): self
    {
        $this->imageMaxSize = $imageMaxSize;

        return $this;
    }

    public function getImageMaxNumber(): ?int
    {
        return $this->imageMaxNumber;
    }

    public function setImageMaxNumber(int $imageMaxNumber): self
    {
        $this->imageMaxNumber = $imageMaxNumber;

        return $this;
    }
}
