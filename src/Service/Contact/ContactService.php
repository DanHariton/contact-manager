<?php

declare(strict_types=1);

namespace App\Service\Contact;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use App\Service\Common\PaginatorProvider;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;

class ContactService
{
    public const ITEM_PER_PAGE = 5;

    public function __construct(
        private readonly ContactRepository $repository,
        private readonly EntityManagerInterface $em,
        private readonly PaginatorProvider $paginatorProvider
    )
    {
    }

    public function saveContact(Contact $contact): Contact
    {
        $this->em->persist($contact);
        $this->em->flush();

        return $contact;
    }

    public function deleteContact(Contact $contact): Contact
    {
        $this->em->remove($contact);
        $this->em->flush();

        return $contact;
    }

    public function paginationList(?int $page = null): PaginationInterface
    {
        return $this->paginatorProvider->createPaginator($this->repository->findAllQuery(), $page, self::ITEM_PER_PAGE);
    }

    public function loadEntity(string $name): ?Contact
    {
        return $this->repository->findByName($name);
    }
}