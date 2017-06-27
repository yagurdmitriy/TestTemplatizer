<?php

namespace TestTemplatizer\Parser\Parser;

use TestTemplatizer\Parser\Handlers\HandlerInterface;
use TestTemplatizer\Parser\Scanner\Scanner;

/**
 * Class AbstractParser
 * @package TestTemplatizer\Parser
 */
abstract class AbstractParser
{
    const GIP_RESPECTSPACE = 1;
    /** @var bool  */
    protected $respectSpace = false;
    /** @var bool  */
    protected static $debug = false;
    /** @var bool  */
    protected $discard = false;
    /** @var string */
    protected $name;
    /** @var int  */
    private static $count = 0;
    /** @var  HandlerInterface */
    protected $handler;

    /**
     * AbstractParser constructor.
     * @param null $name
     * @param null $options
     */
    function __construct($name=null, $options=null)
    {
        if (is_null($name)) {
            self::$count++;
            $this->name = get_class($this).'-'.self::$count;
        } else {
            $this->name = $name;
        }

        if (is_array($options)) {
            if(isset($options[self::GIP_RESPECTSPACE])) {
                $this->respectSpace = true;
            }
        }
    }

    /**
     * @param Scanner $scanner
     */
    protected function next(Scanner $scanner)
    {
        $scanner->nextToken();
        if(!$this->respectSpace) {
            $scanner->eatWhiteSpace();
        }
    }

    /**
     * @param bool $bool
     */
    public function spaceSignificant($bool)
    {
        $this->respectSpace = $bool;
    }

    /**
     * @param bool $bool
     */
    public function setDebug($bool)
    {
        self::$debug = $bool;
    }

    public function setHandler(HandlerInterface $handler)
    {
        $this->handler = $handler;

    }

    /**
     * @param Scanner $scanner
     * @return mixed
     */
    final public function scan(Scanner $scanner)
    {
        if($scanner->tokenType() == Scanner::SOF) {
            $scanner->nextToken();
        }

        $ret = $this->doScan($scanner);
        if($ret && !$this->discard && $this->term()) {
            $this->push($scanner);
        }

        if($ret) {
            $this->invokeHandler($scanner);
        }

        if($this->term() && $ret) {
            $this->next($scanner);
        }
        $this->report("::scan returning $ret");

        return $ret;
    }

    /**
     * @return null
     */
    public function discard()
    {
        $this->discard = true;
    }

    /**
     * @param Scanner $scanner
     * @return mixed
     */
    abstract public function trigger(Scanner $scanner);

    /**
     * @return bool
     */
    public function term()
    {
        return true;
    }

    /**
     * @param Scanner $scanner
     * @return null
     */
    protected function invokeHandler(Scanner $scanner)
    {
        if(!empty($this->handler)) {
            $this->report("calling handler: ". get_class($this->handler));
            $this->handler->handleMatch($this, $scanner);
        }
    }

    /**
     * @param $msg
     */
    protected function report($msg)
    {
        if(self::$debug) {
            print "<{$this->name}>".get_class($this).": $msg <br>";
        }
    }

    /**
     * @param Scanner $scanner
     */
    protected function push(Scanner $scanner)
    {
        $context = $scanner->getContext();
        $context->pushResult($scanner->token());
    }

    /**
     * @param Scanner $scanner
     * @return bool
     */
    abstract protected function doScan(Scanner $scanner);
}