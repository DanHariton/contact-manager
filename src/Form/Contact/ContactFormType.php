<?php

declare(strict_types=1);

namespace App\Form\Contact;

use App\Entity\Contact;
use App\Validation\PhoneNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [new NotBlank()],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('surname', TextType::class, [
                'required' => true,
                'constraints' => [new NotBlank()],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Email()
                ],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('phone', TextType::class, [
                'required' => false,
                'constraints' => [new PhoneNumber()],
                'attr' => [
                    'class' => 'form-control'
                ],
            ])
            ->add('note', TextareaType::class, [
                'required' => false,
                'attr' => [
                    'rows' => '8',
                    'class' => 'form-control'
                ],
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-3'
                ]
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'translation_domain' => 'form_contact'
        ]);
    }
}