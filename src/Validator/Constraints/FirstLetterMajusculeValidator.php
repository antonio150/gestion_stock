<?php

namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FirstLetterMajusculeValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var FirstLetterMajuscule $constraint */

        if (!is_string($value) || '' === $value) {
            return;
        }

        // TODO: implement the validation here
        if (!preg_match('/^[A-Z].*$/', $value)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }

      
}
