<?php

namespace TestTemplatizer\Parser\Parser\CollectionParser;
use TestTemplatizer\Parser\Parser\AbstractParser;

/**
 * Created by PhpStorm.
 * User: dmitriy
 * Date: 26.06.2017
 * Time: 2:02
 */
abstract class AbstractCollectionParser extends AbstractParser
{
    /** @var AbstractParser[]  */
    protected $parsers = [];

    /**
     * @param AbstractParser $parser
     * @return AbstractParser
     * @throws \Exception
     */
    public function add(AbstractParser $parser)
    {
        if (is_null($parser)) {
            throw new \Exception('argument is null');
        }

        $this->parsers[] =  $parser;

        return $parser;
    }
}