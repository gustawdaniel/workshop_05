<?php

namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ConstraintFirstLetter extends Constraint
{
    public $message =
        'The string "{{ string }}" should start with big first letter.';
}