<?php

declare(strict_types=1);

namespace App\Controller\Contact;

use App\Entity\Contact;
use App\Form\Contact\ContactFormType;
use App\Service\Contact\ContactService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route("/", name: "contact_")]
class ContactController extends AbstractController
{
    public function __construct(
        private readonly ContactService $contactService,
        private readonly TranslatorInterface $translator
    )
    {
    }

    #[Route("/", name: "list")]
    public function list(Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pagination = $this->contactService->paginationList($page);

        return $this->render('contact/list.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route("/{name}", name: "edit")]
    #[Route("/contact/create", name: "create")]
    public function create(Request $request, ?string $name): Response
    {
        $isCreatingNewContact = $request->attributes->get('_route') === 'contact_create';

        if ($isCreatingNewContact) {
            $contact = new Contact();
        } else {
            $contact = $this->contactService->loadEntity((string) $name);

            if (!$contact) {
                throw $this->createNotFoundException($this->translator->trans('message.notFound'));
            }
        }

        $form = $this->createForm(ContactFormType::class, $contact)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $this->contactService->saveContact($form->getData());

            return $this->redirectToRoute('contact_edit', ['name' => $contact->getName()]);
        }

        return $this->render('contact/edit.html.twig', [
            'isCreatingNewContact' => $isCreatingNewContact,
            'form'                 => $form->createView(),
            'contact'              => $contact
        ]);
    }

    #[Route("/delete/{contact}", name: "delete")]
    public function delete(Contact $contact): RedirectResponse
    {
        $this->contactService->deleteContact($contact);

        return $this->redirectToRoute('contact_list');
    }
}