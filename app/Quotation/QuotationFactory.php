<?php

declare(strict_types=1);

namespace App\Quotation;

use App\Quotation\Model\Business\Quotation;

final class QuotationFactory
{
    public function createQuotation(): Quotation
    {
        return new Quotation();
    }
}
