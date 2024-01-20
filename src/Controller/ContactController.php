<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ContactRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/", name: "contact_")]
class ContactController extends AbstractController
{
    public function __construct(private readonly ContactRepository $contactRepository)
    {
    }

    #[Route("/", name: "list")]
    public function list()
    {
        dd($this->contactRepository->findAll());
    }
}