<?php

namespace App\Finance\Application\Service;

use App\Core\Domain\Entity\Warning;
use App\Core\Domain\Repository\WarningRepositoryInterface;
use App\Finance\Domain\Repository\InvoiceRespositoryInterface;
use App\Core\Domain\WarningGeneratorInterface;
use App\Finance\Domain\Entity\Invoice;
use InvalidArgumentException;

final class InvoiceWarningGenerator implements WarningGeneratorInterface
{
    public function __construct(
        // private InvoiceRespositoryInterface $invoiceRepository,
        private WarningRepositoryInterface $warningRepository
    ) {
    }

    public function generateWarning(object $object, string $className): Warning
    {
        if (!$object instanceof Invoice) {
            throw new InvalidArgumentException('Expected Invoice object');
        }

        /** @var Invoice $object */
        $warning = new Warning(
            $className,
            $object->getId()->toString(),
            'faktura przeterminowana'
        );

        $this->warningRepository->save($warning);

        return $warning;
    }
}
