<?php

namespace TestTemplatizer\Interpreter\Operators;

use TestTemplatizer\Interpreter\AbstractExpression;
use TestTemplatizer\Interpreter\InterpreterContext;

/**
 * Class IsTrueExpression
 * @package TestTemplatizer\Interpreter\Operators
 */
class ToBoolExpression extends AbstractOperatorExpression
{
    /** @var AbstractExpression */
    private $operand;

    /**
     * IsTrueExpression constructor.
     * @param AbstractExpression $operand
     */
    public function __construct(AbstractExpression $operand)
    {
        $this->operand = $operand;
    }

    /**
     * @param InterpreterContext $context
     * @return Null
     */
    function interpret(InterpreterContext $context)
    {
        $this->operand->interpret($context);
        $this->doInterpret(
            $context,
            $context->lookup($this->operand)
        );
    }

    /**
     * @param InterpreterContext $context
     * @param $operand
     */
    protected function doInterpret(InterpreterContext $context, $operand)
    {
        $context->replace($this, (bool) $operand);
    }
}