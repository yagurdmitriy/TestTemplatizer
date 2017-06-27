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
    /** @var string  */
    private $value;

    /**
     * LiteralExpression constructor.
     * @param string $value
     */
    public function __construct($value)
    {
        $this->value=$value;
    }

    /**
     * @param InterpreterContext $context
     * @return null
     */
    function interpret(InterpreterContext $context)
    {
        $context->replace($this, $this->value);
    }
}