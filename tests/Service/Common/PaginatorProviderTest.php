<?php

declare(strict_types=1);

namespace App\Tests\Service\Common;

use App\Service\Common\PaginatorProvider;
use Doctrine\ORM\Query;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use PHPUnit\Framework\TestCase;

class PaginatorProviderTest extends TestCase
{
    private PaginatorInterface $paginator;
    private PaginatorProvider $paginatorProvider;

    protected function setUp(): void
    {
        $this->paginator = $this->createMock(PaginatorInterface::class);
        $this->paginatorProvider = new PaginatorProvider($this->paginator);
    }

    public function testCreatePaginator(): void
    {
        $query = $this->createMock(Query::class);
        $pagination = $this->createMock(PaginationInterface::class);

        $this->paginator
            ->expects($this->once())
            ->method('paginate')
            ->with(
                $this->equalTo($query),
                $this->equalTo(1),
                $this->equalTo(PaginatorProvider::DEFAULT_ITEM_COUNT)
            )
            ->willReturn($pagination);

        $result = $this->paginatorProvider->createPaginator($query);

        $this->assertSame($pagination, $result);
    }

    public function testCreatePaginatorWithCustomPageAndLimit(): void
    {
        $query = $this->createMock(Query::class);
        $pagination = $this->createMock(PaginationInterface::class);

        $this->paginator
            ->expects($this->once())
            ->method('paginate')
            ->with(
                $this->equalTo($query),
                $this->equalTo(5),
                $this->equalTo(21)
            )
            ->willReturn($pagination);

        $result = $this->paginatorProvider->createPaginator($query, 5, 21);

        $this->assertSame($pagination, $result);
    }
}