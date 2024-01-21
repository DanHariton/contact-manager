<?php

declare(strict_types=1);

namespace App\Validation;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Contracts\Translation\TranslatorInterface;

class PhoneNumberValidator extends ConstraintValidator
{
    /** @var TranslatorInterface $translator */
    private TranslatorInterface $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @param mixed $value
     * @param Constraint $constraint
     */
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PhoneNumber) {
            throw new UnexpectedTypeException($constraint, PhoneNumber::class);
        }

        if ($value == '' || empty($value)) {
            return;
        }

        if (!preg_match_all('/^[+]?([(]?[0-9]{1,3})?[)]?[-\s.]?[(]?[0-9]{1,4}[)]?[-\s.]?[0-9]{2,6}[-\s.]?[0-9]{2,6}([-\s.]?[0-9]{2,6})?$/i', strval($value))) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ message }}', $this->translator->trans('invalid_number', [], 'phone_number_validator'))
                ->addViolation();
        }
    }
}