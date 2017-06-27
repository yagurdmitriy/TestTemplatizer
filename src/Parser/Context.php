<?php

namespace TestTemplatizer\Parser;

use TestTemplatizer\Interpreter\AbstractExpression;
use TestTemplatizer\Interpreter\IterableExpressions\ListExpression;

/**
 * Class Context
 * @package TestTemplatizer\Parser
 */
class Context
{
    /** @var array  */
    public $resultStack = [];

    /** @var ListExpression */
    public $list;

    public function __construct()
    {
        $this->list = new ListExpression();
    }

    /**
     * @param mixed $data
     */
    public function pushResult($data)
    {
        array_push($this->resultStack, $data);
    }

    /**
     * @return mixed
     */
    public function popResult()
    {
        return array_pop($this->resultStack);
    }

    /**
     * @return int
     */
    public function resultCount()
    {
        return count($this->resultStack);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function peekResult()
    {
        if (empty($this->resultStack))
        {
            throw  new \Exception('empty resultStack');
        }

        return $this->resultStack[$this->resultCount()-1];
    }
}