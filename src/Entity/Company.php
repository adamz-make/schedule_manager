<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CompanyRepository::class)
 */
class Company implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @ORM\OneToMany(targetEntity="Schedule", mappedBy="company")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $CompanyName;

    public function __construct(?string $companyName, ?int $id)
    {
        $this->id = $id;
        $this->CompanyName = $companyName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Company
    {
        $this->id = $id;
        return $this;
    }
    public function getCompanyName(): ?string
    {
        return $this->CompanyName;
    }

    public function setCompanyName(string $CompanyName): Company
    {
        $this->CompanyName = $CompanyName;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'companyName' => $this->CompanyName
        ];
    }
}
