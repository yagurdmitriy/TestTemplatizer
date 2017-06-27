<?php

namespace TestTemplatizer\Parser\Scanner;

use TestTemplatizer\Parser\Context;
use TestTemplatizer\Parser\Reader\AbstractReader;

/**
 * Class Scanner
 * @package TestTemplatizer\Parser
 */
class Scanner
{

    const WORD = 1;
    const BRACE_OPEN = 3;
    const BRACE_CLOSE = 4;
    const WHITESPACE = 6;
    const EOL = 7;
    const CHAR = 8;
    const EOF = 0;
    const SOF = -1;

    const MAP_TOKEN_TO_STING = [
        self::WORD => 'WORD',
        self::BRACE_OPEN => 'BRACE_OPEN',
        self::BRACE_CLOSE => 'BRACE_CLOSE',
        self::WHITESPACE => 'WHITESPACE',
        self::EOL => 'EOL',
        self::CHAR => 'CHAR',
        self::EOF => 'EOF',
        self::SOF => 'SOF',
    ];


    protected $lineNumber = 1;
    protected $charNumber = 0;
    protected $token = null;
    protected $tokenType = -1;

    /** @var AbstractReader */
    protected $reader;
    /** @var Context */
    protected $context;

    public function __construct(AbstractReader $reader, Context $context)
    {
        $this->reader = $reader;
        $this->context = $context;
    }

    /**
     * @return Context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return int
     */
    public function eatWhiteSpace()
    {
        $counter = 0;
        if ($this->tokenType != self::WHITESPACE && $this->tokenType != self::EOL) {
            return $counter;
        }
        while ($this->nextToken() == self::WHITESPACE || $this->tokenType == self::EOL) {
            $counter++;
        }

        return $counter;
    }

    /**
     * @param int $tokenId
     * @return mixed|null
     */
    public function getTypeString($tokenId = -1)
    {
        if ($tokenId < 0) {
            $tokenId = $this->tokenType();
        }

        if ($tokenId < 0) {
            return null;
        }

        return self::MAP_TOKEN_TO_STING[$tokenId];
    }

    /**
     * @return mixed
     */
    public function tokenType()
    {
        return $this->tokenType;
    }

    /**
     * @return mixed
     */
    public function token()
    {
        return $this->token;
    }

    /**
     * @return bool
     */
    public function isWord()
    {
        return $this->tokenType == self::WORD;
    }

    /**
     * @return bool
     */
    public function  isBraceOpen()
    {
        return $this->tokenType == self::BRACE_OPEN;
    }

    /**
     * @return bool
     */
    public function  isBraceClose()
    {
        return $this->tokenType == self::BRACE_CLOSE;
    }

    /**
     * @return mixed
     */
    public function lineNumber()
    {
        return $this->lineNumber;
    }

    /**
     * @return mixed
     */
    public function charNumber()
    {
        return $this->charNumber;
    }

    public function __clone()
    {
        $this->reader = clone($this->reader);
    }

    /**
     * @return int
     */
    public function nextToken()
    {
        $this->token = null;
        while (!is_bool($char = $this->getChar())) {
            if ($this->isEolChar($char)) {
                $this->token = $this->manageEolChars($char);
                $this->lineNumber++;
                $this->charNumber = 0;
                $type = self::EOL;
                return $this->tokenType = $type;
            } else if ($this->isWordChar($char)) {
                $this->token = $this->eatWordChars($char);
                $type = self::WORD;
            } else if ($this->isSpaceChar($char)) {
                $this->token = $this->eatSpaceChars($char);
                $type = self::WHITESPACE;
            } else if ($char == '{') {
                $this->token = $char;
                $type = self::BRACE_OPEN;
            } else if ($char == '}') {
                $this->token = $char;
                $type = self::BRACE_CLOSE;
            } else {
                $this->token = $char;
                $type = self::CHAR;
            }

            $this->charNumber += strlen($this->token());
            return ($this->tokenType = $type);
        }
        return $this->tokenType = self::EOF;
    }

    /**
     * @return ScannerState
     */
    public function getState()
    {
        $state = new ScannerState();
        $state->lineNumber = $this->lineNumber;
        $state->charNumber = $this->charNumber;
        $state->token = $this->token;
        $state->tokenType = $this->tokenType;
        $state->reader = clone($this->reader);
        $state->context = clone($this->context);

        return $state;
    }

    /**
     * @param ScannerState $state
     * @return null
     */
    public function setState(ScannerState $state)
    {
        $this->lineNumber = $state->lineNumber;
        $this->charNumber = $state->charNumber;
        $this->token = $state->token;
        $this->tokenType = $state->tokenType;
        $this->reader = $state->reader;
        $this->context = $state->context;
    }

    /**
     * @return mixed
     */
    private function getChar()
    {
        return $this->reader->getChar();
    }

    /**
     * @param string $char
     * @return string
     */
    private function eatWordChars($char)
    {
        $value = $char;
        while ($this->isWordChar($char = $this->getChar())) {
            $value .= $char;
        }

        if($char) {
            $this->pushBackChar();
        }
        return $value;
    }

    /**
     * @param string $char
     * @return string
     */
    private function eatSpaceChars($char)
    {
        $value = $char;
        while ($this->isSpaceChar($char = $this->getChar())) {
            $value .= $char;
        }
        $this->pushBackChar();

        return $value;
    }

    /**
     * @return null
     */
    public function pushBackChar()
    {
        $this->reader->pushBackChar();
    }

    /**
     * @param $char
     * @return bool
     */
    private function isWordChar($char)
    {
        return preg_match('~[A-za-z0-9_\-]~', $char) === 1;
    }

    /**
     * @param $char
     * @return bool
     */
    private function isSpaceChar($char)
    {
        return preg_match('~\t| ~', $char) === 1;
    }

    /**
     * @param $char
     * @return bool
     */
    private function isEolChar($char)
    {
        return preg_match('~\n|\r~', $char) === 1;
    }

    /**
     * @param $char
     * @return string
     */
    private function manageEolChars($char)
    {
        if ($char == "\r") {
            $nextChar = $this->getChar();
            if ($nextChar == "\n") {
                return "{$char}{$nextChar}";
            } else {
                $this->pushBackChar();
            }
        }

        return $char;
    }

    /**
     * @return mixed
     */
    public function getPosition()
    {
        return $this->reader->getPosition();
    }
}