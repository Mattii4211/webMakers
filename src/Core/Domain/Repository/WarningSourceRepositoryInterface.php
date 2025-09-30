<?php

namespace App\Core\Domain\Repository;

/**
 * @template T of object
 */
interface WarningSourceRepositoryInterface
{
    /**
     * @return iterable<T>
     */
    public function findAllWithWarning(): iterable;
}
