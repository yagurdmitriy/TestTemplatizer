<?php

namespace TestTemplatizer\Interpreter\Expressions;

use TestTemplatizer\Interpreter\AbstractExpression;
use TestTemplatizer\Interpreter\InterpreterContext;

/**
 * Class LiteralExpression
 * @package TestTemplatizer\Interpreter\Expressions
 */
class LiteralExpression extends AbstractExpression
{
    private $value;

    public function __construct($value)
    {
        $this->value=$value;
    }

    function interpret(InterpreterContext $context)
    {
        $context->replace($this, $this->value);
    }
}