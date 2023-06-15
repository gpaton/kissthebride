<?php

namespace App\Entity;

use App\Enum\ExpenseReportTypeEnum;
use App\Repository\ExpenseReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[ORM\Entity(repositoryClass: ExpenseReportRepository::class)]
class ExpenseReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'd/m/Y'])]
    #[SerializedName('date')]
    private ?\DateTimeInterface $expenseDate = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $amount = null;

    #[ORM\Column(length: 255, enumType: ExpenseReportTypeEnum::class)]
    #[SerializedName('type')]
    private ?ExpenseReportTypeEnum $expenseType = null;

    #[ORM\Column(length: 255)]
    private ?string $company = null;

    #[ORM\Column]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'd/m/Y H:i:s'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'expenseReports')]
    #[ORM\JoinColumn(nullable: false)]
    #[Ignore]
    private ?User $user = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExpenseDate(): ?\DateTimeInterface
    {
        return $this->expenseDate;
    }

    public function setExpenseDate(\DateTimeInterface $expenseDate): static
    {
        $this->expenseDate = $expenseDate;

        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): static
    {
        $this->amount = $amount;

        return $this;
    }

    public function getExpenseType(): ?ExpenseReportTypeEnum
    {
        return $this->expenseType;
    }

    public function setExpenseType(ExpenseReportTypeEnum $expenseType): static
    {
        $this->expenseType = $expenseType;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
