<?php
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Dom;


class NodeList extends \Dogma\Object implements \Countable, \Iterator
{

    /** @var \DOMNodeList */
    private $nodeList;

    /** @var \Dogma\Dom\QueryEngine */
    private $engine;

    /** @var integer */
    private $offset = 0;

    /**
     * @param \DOMNodeList
     * @param \Dogma\Dom\QueryEngine
     */
    public function __construct(\DOMNodeList $nodeList, QueryEngine $engine)
    {
        $this->nodeList = $nodeList;
        $this->engine = $engine;
    }

    /**
     * @param integer $offset
     * @return \Dogma\Dom\Element|\DOMNode
     */
    public function item($offset)
    {
        return $this->wrap($this->nodeList->item($offset));
    }

    /**
     * @return integer
     */
    public function count()
    {
        // PHP bug - cannot count items using $length
        $n = 0;
        while ($this->nodeList->item($n)) {
            $n++;
        }
        return $n;
    }

    /**
     * @return \Dogma\Dom\Element|\DOMNode
     */
    public function current()
    {
        return $this->wrap($this->nodeList->item($this->offset));
    }

    /**
     * @return integer
     */
    public function key()
    {
        return $this->offset;
    }

    public function next()
    {
        $this->offset++;
    }

    public function rewind()
    {
        $this->offset = 0;
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        // PHP bug - cannot iterate through items
        return $this->nodeList->item($this->offset) !== null;
    }

    /**
     * @param \DOMNode
     * @return \Dogma\Dom\Element|\DOMNode
     */
    private function wrap($node)
    {
        if ($node instanceof \DOMElement) {
            return new Element($node, $this->engine);
        } else {
            return $node;
        }
    }

    public function dump()
    {
        Dumper::dump($this);
    }

}
