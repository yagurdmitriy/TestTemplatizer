<?php

namespace TestTemplatizer\Interpreter\IterableExpressions;

use TestTemplatizer\Interpreter\AbstractExpression;
use TestTemplatizer\Interpreter\InterpreterContext;
use Traversable;

/**
 * Class AbstractIterableExpression
 * @package TestTemplatizer\Interpreter\Expressions
 */
class AbstractIterableExpression extends AbstractExpression{

    protected $container = [];

    /**
     * AbstractIterableExpression constructor.
     * @param array $array
     * @throws \Exception
     */
    public function __construct($array = [])
    {
        foreach ($array as $item) {
            if($item instanceOf AbstractExpression) {
                $this->container[] = $item;
            } else {
                throw new \Exception('Item not AbstractExpression');
            }
        }

        $this->collection = $array;
    }

    /**
     * @param AbstractExpression $expression
     */
    public function add(AbstractExpression $expression)
    {
        $this->container[] = $expression;
    }

    /**
     * @param InterpreterContext $context
     * @return null
     */
    public function interpret(InterpreterContext $context)
    {
        foreach ($this->container as $item) {
            $item->interpret($context);
        }
        $this->doInterpret($context, $this->container);
    }

    protected function doInterpret(InterpreterContext $context, array $value){
        $return = '';
        foreach ($value as $item) {
            $return .= $context->lookup($item);
        }

        $context->replace($this, $return);
    }
}