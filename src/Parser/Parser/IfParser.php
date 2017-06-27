<?php

namespace TestTemplatizer\Parser\Parser;


use TestTemplatizer\Parser\Parser\CollectionParser\SequenceParser;
use TestTemplatizer\Parser\Reader\StringReader;
use TestTemplatizer\Parser\Scanner\Scanner;

class IfParser extends AbstractParser
{

    /** @var SequenceParser  */
    protected $ifParser;
    /** @var  AbstractParser */
    protected $thenParser;
    /** @var SequenceParser  */
    protected $closeIfParser;

    public function __construct($name = null, $options = null)
    {
        $this->ifParser = new SequenceParser();
        $this->ifParser->add(new CharacterParser('{'))->discard();
        $this->ifParser->add(new WordParser('if'))->discard();
        $this->ifParser->add(new WordParser());
        $this->ifParser->add(new CharacterParser('}'))->discard();

        $this->closeIfParser = new SequenceParser();
        $this->closeIfParser->add(new CharacterParser('{'))->discard();
        $this->closeIfParser->add(new CharacterParser('/'))->discard();
        $this->ifParser->add(new WordParser('if'))->discard();
        $this->closeIfParser->add(new CharacterParser('}'))->discard();
        parent::__construct($name, $options);

    }

    /**
     * @param mixed $thenParser
     */
    public function setThenParser($thenParser)
    {
        $this->thenParser = $thenParser;
    }


    /**
     * @param Scanner $scanner
     * @return bool
     */
    public function trigger(Scanner $scanner)
    {
        return $this->ifParser->trigger($scanner);
    }

    /**
     * @param Scanner $scanner
     * @return bool
     */
    protected function doScan(Scanner $scanner)
    {
        $startState1 = $scanner->getState();
        $startState = $scanner->getState();
        if(!($this->ifParser->trigger($scanner) && $scan = $this->ifParser->scan($scanner))) {
            $scanner->setState($startState);
            return false;
        }

        $scannerCounter = [];
        $string = "";
        $closeCounter = 0;

        while($scanner->tokenType() != Scanner::EOF) {
            while(!($this->closeIfParser->trigger($scanner)&& $scan = $this->closeIfParser->scan($scanner)) ) {
                if($scanner->tokenType() != Scanner::EOF) {
                    continue 2;
                } else {
                    $string .= $scanner->token();
                    $scannerCounter[$closeCounter] = $string;
                    $scanner->nextToken();
                }
            }
            $closeCounter++;
        }

        if($closeCounter === 0) {
            throw new \Exception('If don\'t close');
        }

        $startState->reader = new StringReader(array_pop($scannerCounter));
        $scanner->setState($startState);

        if(!($this->thenParser->trigger($scanner) && $scan = $this->thenParser->scan($scanner))) {
            $scanner->setState($startState1);
            return false;
        }

        return true;
    }

}