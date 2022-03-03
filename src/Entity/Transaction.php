<?php

namespace App\Entity;

use App\Repository\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransactionRepository::class)
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ff;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $id_nft;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $qte;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFf(): ?string
    {
        return $this->ff;
    }

    public function setFf(string $ff): self
    {
        $this->ff = $ff;

        return $this;
    }

    public function getTt(): ?string
    {
        return $this->tt;
    }

    public function setTt(string $tt): self
    {
        $this->tt = $tt;

        return $this;
    }

    public function getIdNft(): ?string
    {
        return $this->id_nft;
    }

    public function setIdNft(string $id_nft): self
    {
        $this->id_nft = $id_nft;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQte(): ?int
    {
        return $this->qte;
    }

    public function setQte(int $qte): self
    {
        $this->qte = $qte;

        return $this;
    }
}
