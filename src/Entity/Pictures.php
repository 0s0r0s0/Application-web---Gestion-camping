<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PicturesRepository")
 */
class Pictures
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
    private $filename;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $principale;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Templates", inversedBy="pictures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $template;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getPrincipale(): ?string
    {
        return $this->principale;
    }

    public function setPrincipale(string $principale): self
    {
        $this->principale = $principale;

        return $this;
    }

    public function getTemplate(): ?Templates
    {
        return $this->template;
    }

    public function setTemplate(?Templates $template): self
    {
        $this->template = $template;

        return $this;
    }
}
