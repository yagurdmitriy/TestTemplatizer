<?php

namespace TestTemplatizer\Parser\Reader;

/**
 * Class Reader
 * @package TestTemplatizer\Parser
 */
abstract class AbstractReader
{
    abstract function getChar();
    abstract function getPosition();
    abstract function pushBackChar();
}