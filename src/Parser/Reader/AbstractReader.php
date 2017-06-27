<?php

namespace TestTemplatizer\Parser\Reader;

/**
 * Class Reader
 * @package TestTemplatizer\Parser
 */
abstract class AbstractReader
{
    /** @return  string */
    abstract function getChar();
    /** @return int */
    abstract function getPosition();
    /** @return null */
    abstract function pushBackChar();
}
