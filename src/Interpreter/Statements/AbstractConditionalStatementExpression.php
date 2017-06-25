<?php

namespace TestTemplatizer\Interpreter\Statements;
use TestTemplatizer\Interpreter\AbstractExpression;
use TestTemplatizer\Interpreter\Expressions\LiteralExpression;
use TestTemplatizer\Interpreter\InterpreterContext;
use TestTemplatizer\Interpreter\Operators\AbstractOperatorExpression;

/**
 * Class AbstractConditionalStatement
 * @package TestTemplatizer\Interpreter\Statementsstatements
 */
class AbstractConditionalStatementExpression extends AbstractExpression
{
    /** @var AbstractOperatorExpression  */
    protected $conditionExpression;
    /** @var AbstractExpression $thenExpression */
    protected $thenExpression;
    /** @var AbstractExpression AbstractExpression */
    protected $elseExpression;


    /**
     * AbstractConditionalStatementExpression constructor.
     * @param AbstractOperatorExpression $conditionExpression
     * @param AbstractExpression         $thenExpression
     * @param AbstractExpression|null    $elseExpression
     */
    public function __construct(AbstractOperatorExpression $conditionExpression, AbstractExpression $thenExpression, AbstractExpression $elseExpression = null)
    {
        $this->conditionExpression = $conditionExpression;
        $this->thenExpression = $thenExpression;
        $this->elseExpression = !is_null($elseExpression) ? $elseExpression : new LiteralExpression('');
    }

    /**
     * @param InterpreterContext $context
     * @return null
     */
    public function interpret(InterpreterContext $context)
    {
        $this->conditionExpression->interpret($context);
        $this->thenExpression->interpret($context);
        $this->elseExpression->interpret($context);
        $this->doInterpret(
            $context,
            $context->lookup($this->conditionExpression),
            $context->lookup($this->thenExpression),
            $context->lookup($this->elseExpression)
        );
    }

    protected function doInterpret(InterpreterContext $context, $conditionExpression, $thenExpression, $elseExpression){
        $context->replace($this, $conditionExpression ? $thenExpression : $elseExpression);
    }


}