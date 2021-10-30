<?php

namespace Procountor\Tests\TestDoubles;

use Procountor\Procountor\Interfaces\InvoiceRowInterface;


class InvoiceRow extends AbstractBase implements InvoiceRowInterface
{

    public function getProductId(): ?int
    {
        return $this->faker->numberBetween();
    }

    public function getProduct(): string
    {
        return $this->faker->text(30);
    }

    public function getProductCode(): ?string
    {
        return $this->faker->slug(3);
    }

    public function getQuantity(): float
    {
        return $this->faker->numberBetween(1, 100);
    }

    public function getUnit(): string
    {
        return 'PIECE';
    }

    public function getUnitPrice(): float
    {
        return $this->faker->numberBetween(1, 2000);
    }

    public function getDiscountPercent(): float
    {
        return 0;
    }

    public function getVatPercent(): int
    {
        return 24;
    }

    public function getComment(): ?string
    {
        return $this->faker->paragraph();
    }
}
