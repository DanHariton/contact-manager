<?php

declare(strict_types=1);

namespace App\Validation;

use Symfony\Component\Validator\Constraint;

class PhoneNumber extends Constraint
{
    /** @var string $message */
    public string $message = '{{ message }}';
}