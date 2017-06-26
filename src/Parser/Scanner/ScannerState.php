<?php

namespace TestTemplatizer\Parser\Scanner;

/**
 * Class ScannerState
 * @package TestTemplatizer\Parser
 */
class ScannerState
{
    public $lineNumber;
    public $charNumber;
    public $token;
    public $tokenType;
    public $reader;
    public $context;

}