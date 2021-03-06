<?php

namespace App\Tests\Component\Validator\Type;

use Symfony\Component\Validator\Constraint;

class StringType extends Constraint
{
    private $targetEntity;
    private $message = "string.is_string.invalidate";
    private $values = [
                        'string' => [
                            0 => 5,
                            1 => ['value' => false, 'format' => null, 'return' => false],
                            2 => ['value' => true, 'format' => null, 'return' => false],
                            3 => ['value' => null, 'format' => null, 'return' => false],
                            4 => ['value' => 'abc', 'format' => null, 'return' => true],
                            5 => ['value' => '23', 'format' => null, 'return' => true],
                            6 => ['value' => '23.5', 'format' => null, 'return' => true],
                            7 => ['value' => 23.5, 'format' => null, 'return' => false],
                            8 => ['value' => '', 'format' => null, 'return' => true],
                            9 => ['value' => ' ', 'format' => null, 'return' => true],
                            10 => ['value' => '0', 'format' => null, 'return' => true],
                            11 => ['value' => 0, 'format' => null, 'return' => false]
                        ]
                    ];

    public function getMessage()
    {
        return $this->message;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function getNbInvalidate()
    {
        return $this->values['string'][0];
    }

    public function isValidateConstraint($value, $format = null)
    {
        return is_string($value);
    }
}
