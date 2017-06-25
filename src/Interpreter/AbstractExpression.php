<?php

namespace TestTemplatizer\Interpreter;

/**
 * Class AbstractExpression
 * @package TestTemplatizer
 */
abstract class AbstractExpression
{
    /** @var int  */
    private  static  $keycount = 0;
    /** @var int */
    private $key;

    /**
     * @param InterpreterContext $context
     * @return mixed
     */
    abstract public function interpret(InterpreterContext $context);

    /**
     * @return int
     */
    public function getKey()
    {
        if (!isset($this->key)) {
            self::$keycount++;
            $this->key=self::$keycount;
        }

        return $this->key;
    }
}