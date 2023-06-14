<?php

namespace App\Form;

use App\Enum\ExpenseReportTypeEnum;
use Symfony\Component\Validator\Constraints as Assert;

class ExpenseReportForm
{
    #[Assert\NotBlank]
    #[Assert\Date]
    public ?string $expenseDate = null;

    #[Assert\NotBlank]
    #[Assert\Positive]
    #[Assert\LessThan(
        value: 100000000
    )]
    public ?string $amount = null;

    #[Assert\NotBlank]
    #[Assert\Choice(
        callback: [ExpenseReportTypeEnum::class, 'getValues']
    )]
    public ?string $expenseType = null;

    #[Assert\NotBlank]
    #[Assert\Length(
        min: 1,
        max: 255
    )]
    public ?string $company = null;

    public function getExpenseDate(): ?string
    {
        return $this->expenseDate;
    }
    public function setExpenseDate(?string $expenseDate): self
    {
        $this->expenseDate = $expenseDate;
        
        return $this;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }
    public function setAmount(?string $amount): self
    {
        $this->amount = $amount;
        
        return $this;
    }

    public function getExpenseType(): ?string
    {
        return $this->expenseType;
    }
    public function setExpenseType(?string $expenseType): self
    {
        $this->expenseType = $expenseType;
        
        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }
    public function setCompany(?string $company): self
    {
        $this->company = $company;
        
        return $this;
    }
}