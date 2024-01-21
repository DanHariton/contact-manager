<?php

declare(strict_types=1);

namespace App\Service\Common;

use Doctrine\ORM\Query;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;

class PaginatorProvider
{
    public const DEFAULT_ITEM_COUNT = 10;

    public function __construct(private readonly PaginatorInterface $paginator)
    {
    }

    public function createPaginator(Query $query, ?int $page = null, ?int $limit = null): PaginationInterface
    {
        $page = $page ?? 1;

        return $this->paginator->paginate(
            $query,
            $page,
            $limit ?? self::DEFAULT_ITEM_COUNT
        );
    }
}