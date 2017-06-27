<?php

namespace TestTemplatizer\Parser\Reader;


class StringReader extends AbstractReader
{
    /** @var string  */
    private $container;
    /** @var int */
    private $position;

    /**
     * StringReader constructor.
     * @param $container
     */
    public function __construct($container)
    {
        $this->container = $container;
        $this->position = 0;
    }

    /**
     * {@inheritDoc}
     */
    function getChar()
    {
       if($this->position >= strlen($this->container)) {
           return false;
       }

       $char = substr($this->container, $this->position, 1);
       $this->position++;

       return $char;
    }

    /**
     * {@inheritDoc}
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * {@inheritDoc}
     */
    public function pushBackChar()
    {
        $this->position--;
    }

    /**
     * @return string
     */
    public function string()
    {
        return $this->container;
    }
}