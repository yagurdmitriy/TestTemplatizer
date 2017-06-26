<?php

namespace TestTemplatizer\Interpreter\Expressions;

use TestTemplatizer\Interpreter\AbstractExpression;
use TestTemplatizer\Interpreter\InterpreterContext;

/**
 * Class VariableExpression
 * @package TestTemplatizer\Interpreter\Expressions
 */
class VariableExpression extends AbstractExpression
{
    private $name;
    private $value;

    public function __construct($name, $value=null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    function interpret(InterpreterContext $context)
    {
        if (!is_null($this->value)) {
            $context->replace($this, $this->value);
            $this->value = null;
        }
    }

    /**
     * @param null $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getKey()
    {
        return $this->name;
    }
}