<?php

namespace TestTemplatizer\Parser\Scanner;
use TestTemplatizer\Parser\Context;
use TestTemplatizer\Parser\Reader\AbstractReader;

/**
 * Class ScannerState
 * @package TestTemplatizer\Parser
 */
class ScannerState
{
    /** @var int */
    public $lineNumber;
    /** @var string */
    public $charNumber;
    /** @var string */
    public $token;
    /** @var int */
    public $tokenType;
    /** @var AbstractReader */
    public $reader;
    /** @var Context */
    public $context;
}
