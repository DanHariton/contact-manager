<?php

declare(strict_types=1);

namespace App\Tests\Service\Contact;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Service\Common\PaginatorProvider;
use App\Service\Contact\ContactService;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use PHPUnit\Framework\TestCase;
use Doctrine\ORM\Query;

class ContactServiceTest extends TestCase
{
    private ContactRepository $repository;
    private EntityManagerInterface $entityManager;
    private PaginatorProvider $paginatorProvider;
    private ContactService $contactService;

    protected function setUp(): void
    {
        $this->repository = $this->createMock(ContactRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->paginatorProvider = $this->createMock(PaginatorProvider::class);

        $this->contactService = new ContactService($this->repository, $this->entityManager, $this->paginatorProvider);
    }

    public function testSaveContact(): void
    {
        $contact = new Contact();

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($contact);

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $result = $this->contactService->saveContact($contact);

        $this->assertSame($contact, $result);
    }

    public function testDeleteContact(): void
    {
        $contact = new Contact();

        $this->entityManager
            ->expects($this->once())
            ->method('remove')
            ->with($contact);

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $result = $this->contactService->deleteContact($contact);

        $this->assertSame($contact, $result);
    }

    public function testPaginationList(): void
    {
        $pagination = $this->createMock(PaginationInterface::class);

        $query = $this->createMock(Query::class);

        $this->repository
            ->expects($this->once())
            ->method('findAllQuery')
            ->willReturn($query);

        $this->paginatorProvider
            ->expects($this->once())
            ->method('createPaginator')
            ->with($query, 1, ContactService::ITEM_PER_PAGE)
            ->willReturn($pagination);

        $result = $this->contactService->paginationList(1);

        $this->assertSame($pagination, $result);
    }

    public function testLoadEntity(): void
    {
        $name = 'TestName';
        $contact = new Contact();

        $this->repository
            ->expects($this->once())
            ->method('findByName')
            ->with($name)
            ->willReturn($contact);

        $result = $this->contactService->loadEntity($name);

        $this->assertSame($contact, $result);
    }
}