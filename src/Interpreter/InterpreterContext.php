<?php

namespace TestTemplatizer\Interpreter;

/**
 * Class InterpreterContext
 * @package TestTemplatizer\Interpreter
 */
class InterpreterContext
{
    /** @var array  */
    private $expressionStore = [];

    /**
     * @param AbstractExpression $expression
     * @param mixed              $value
     */
    public function replace(AbstractExpression $expression, $value)
    {
        $this->expressionStore[$expression->getKey()] = $value;
    }

    public function lookup(AbstractExpression $expression)
    {
        return $this->expressionStore[$expression->getKey()];
    }

}