<?php

namespace App\Test\Constraint\UnitTest;

use App\Validator\Constraints\FirstLetterMajuscule;
use App\Validator\Constraints\FirstLetterMajusculeValidator;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class FirstLetterMajusculeTest extends ConstraintValidatorTestCase
{

    protected function createValidator(): ConstraintValidatorInterface
    {
        return new FirstLetterMajusculeValidator();
    }

    public function testValidValue()
    {
        $this->validator->validate('Oymfony', new FirstLetterMajuscule());

        $this->assertNoViolation();
    }

}
