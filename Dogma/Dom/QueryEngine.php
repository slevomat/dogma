<?php
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Dom;

use Nette\Utils\Strings;


/**
 * Simple query engine based on XPath 1.0
 */
class QueryEngine extends \Dogma\Object
{

    /** @var \DOMXPath */
    private $xpath;

    /**
     * @var string[] (string $pattern => string $replacement)
     */
    private $translations = [
        // index: [n]
        '/\\[([0-9]+)..([0-9]+)\\]/' => '[position() >= $1 and position() <= $2]', // [m..n]
        '/\\[..([0-9]+)\\]/' => '[position() <= $1]', // [..n]
        '/\\[([0-9]+)..\\]/' => '[position() >= $1]', // [n..]
        '/\\[-([0-9]+)\\]/'  => '[position() = last() + 1 - $1]', // nth from end: [-n]
        '/\\[:first\\]/' => '[1]', // [:first]
        '/\\[:last\\]/'  => '[last()]', // [:last]
        '/\\[:even\\]/'  => '[position() mod 2]', // [:even]
        '/\\[:odd\\]/'   => '[not(position() mod 2)]', // [:odd]
        '/\\[:only\\]/'  => '[position() = 1 and position() = last()]', // [:only]

        // class: [.foo]
        '/\\[\\.([A-Za-z0-9_-]+)\\]/' => '[contains(concat(" ", normalize-space(@class), " "), " $1 ")]',

        // id: [#foo]
        '/\\[#([A-Za-z0-9_-]+)\\]/' => '[@id = "$1"]',

        // name: ["foo"]
        '/\\["([^"]+)"\\]/' => '[@name = "$1"]',
        "/\\['([^']+)'\\]/" => "[@name = '$1']",

        // content equals: [="foo"]
        '/\\[="([^"]+)"\\]/' => '[string() = "$1"]',
        "/\\[='([^']+)'\\]/" => "[string() = '$1']",

        // content matches: [~"/foo/i"]
        '/\\[~"([^"]+)"\\]/' => "[php:functionString('Dogma\\Dom\\QueryEngine::match', string(), \"$1\")]",
        "/\\[~'([^']+)'\\]/" => "[php:functionString('Dogma\\Dom\\QueryEngine::match', string(), '$1')]",

        // label: [label("foo")]
        '/\\[label\\("([^"]+)"\\)\\]/' => '[
                (ancestor::label[normalize-space() = "$1"]) or
                (@id = ancestor::form/descendant::label[normalize-space() = "$1"]/@for) or
                ((@type = "submit" or @type = "reset" or @type = "button") and @value = "$1") or
                (@type = "button" and normalize-space() = "$1")]',
        "/\\[label\\('([^']+)'\\)\\]/" => '[
                (ancestor::label[normalize-space() = \'$1\']) or
                (@id = ancestor::form/descendant::label[normalize-space() = \'$1\']/@for) or
                ((@type = "submit" or @type = "reset" or @type = "button") and @value = \'$1\') or
                (@type = "button" and normalize-space() = \'$1\')]',

        // axes 'next' and 'previous'
        '#/previous::([A-Za-z0-9_-]+)#' => '/preceding-sibling::$1[last()]',
        '#/next::([A-Za-z0-9_-]+)#'     => '/following-sibling::$1[1]',

        // table shortcuts
        '/:headrow/' => "tr[name(..) = 'thead' or (name(..) = 'table' and not(../thead) and position() = 1)]",
        '/:bodyrow/' => "tr[name(..) = 'tbody' or (name(..) = 'table' and not(../tbody) and (../thead or position() != 1))]",
        '/:footrow/' => "tr[name(..) = 'tfoot' or (name(..) = 'table' and not(../tfoot) and position() = last()]",
        '/:cell/'    => "*[name() = 'td' or name() = 'th']",

        // function shortcuts
        '/int\\(/'      => 'number(.//',
        '/float\\(/'    => 'number(.//',
        '/bool\\(/'     => 'php:functionString("Dogma\\Dom\\QueryEngine::bool", .//',
        '/date\\(/'     => 'php:functionString("Dogma\\Dom\\QueryEngine::date", .//',
        '/datetime\\(/' => 'php:functionString("Dogma\\Dom\\QueryEngine::datetime", .//',
        '/match\\(/'    => 'php:functionString("Dogma\\Dom\\QueryEngine::match", .//',
        '/replace\\(/'  => 'php:functionString("Dogma\\Dom\\QueryEngine::replace", .//',

        // jQuery-like shortcuts
        /*
        '/:input/' => "*[name() = 'input' or name() = 'textarea' or name() = 'select' or name() = 'button']",
        '/:file/'  => "input[@type = 'file']",
        '/:button/' => "*[name() = 'button' or (name() = 'input' and @type = 'button')]",
        '/:submit/' => "input[@type = 'submit']",
        '/:reset/' => "input[@type = 'reset']",
        '/:image/' => "input[@type = 'image']",
        '/:radio/' => "input[@type = 'radio']",
        '/:checkbox/' => "input[@type = 'checkbox']",
        '/:text/' => "*[name() = 'textarea'
                or (name() = 'input' and (@type = 'text' or @type= 'hidden' or not(@type)))]",
        '/:password/' => "input[@type = 'password']",

        '/:header/' => "*[name() = 'h1' or name() = 'h2' or name() = 'h3' or name() = 'h4' or name() = 'h5' or name() = 'h6']",
        '/:link/'   => "a[@href]",
        '/:anchor/' => "*[@id or (name() = 'a' and @name)]",
        */
    ];


    /**
     * @var string[]
     */
    private $nativeFunctions = [
        'position',
        'last',
        'count',
        'id',
        'name',
        'local-name',
        'namespace-uri',

        'string',
        'concat',
        'starts-with',
        'contains',
        'substring',
        'substring-before',
        'substring-after',
        'string-length',
        'normalize-space',
        'translate',

        'boolean',
        'not',
        'true',
        'false',
        'lang',
        'number',
        'floor',
        'ceiling',
        'round',
        'sum',

        'function',
        'functionString',

        'match',
        'replace',
        'date',
        'datetime',
        'bool'
    ];


    /**
     * @var string[]
     */
    private $userFunctions = [
        'Dogma\\Dom\\QueryEngine::match',
        'Dogma\\Dom\\QueryEngine::replace',
        'Dogma\\Dom\\QueryEngine::date',
        'Dogma\\Dom\\QueryEngine::datetime',
        'Dogma\\Dom\\QueryEngine::bool',
    ];

    /**
     * @param \DOMDocument
     */
    public function __construct(\DOMDocument $dom)
    {
        $this->xpath = new \DOMXPath($dom);

        $this->xpath->registerNamespace('php', 'http://php.net/xpath');
        $this->xpath->registerPhpFunctions($this->userFunctions);
    }

    /**
     * @param string
     * @param string
     * @param boolean
     */
    public function registerFuction($name, $alias = '', $expectNode = false)
    {
        if (!$alias) {
            $alias = $name;
        }
        if (in_array($alias, $this->nativeFunctions)) {
            throw new QueryEngineException(sprintf('Function \'%s\' is already registered.', $alias));
        }

        if ($expectNode) {
            $this->translations['/' . $alias . '\\(/'] = sprintf('php:function(\'%s\', .//', $name);
        } else {
            $this->translations['/' . $alias . '\\(/'] = sprintf('php:functionString(\'%s\', .//', $name);
        }
        $this->nativeFunctions[] = $alias;
        $this->userFunctions[] = $name;

        $this->xpath->registerPhpFunctions($this->userFunctions);
    }

    /**
     * @param string
     * @param string
     */
    public function registerNamespace($prefix, $uri)
    {
        $this->xpath->registerNamespace($prefix, $uri);
    }

    /**
     * Find nodes
     * @param string
     * @param \DOMNode
     * @return \Dogma\Dom\NodeList
     */
    public function find($query, $context = null)
    {
        $path = $this->translateQuery($query, (bool) $context);
        if ($context) {
            $list = $this->xpath->query($path, $context);
        } else {
            $list = $this->xpath->query($path);
        }
        if ($list === false) {
            throw new QueryEngineException(sprintf('Invalid XPath query: \'%s\', translated from: \'%s\'.', $path, $query));
        }

        return new NodeList($list, $this);
    }

    /**
     * Find one node
     * @param string
     * @param \Dogma\Dom\Element|\DOMNode
     * @return \DOMNode|\Dogma\Dom\Element|null
     */
    public function findOne($query, $context = null)
    {
        $path = $this->translateQuery($query, (bool) $context);
        if ($context) {
            $list = $this->xpath->query($path, $context);
        } else {
            $list = $this->xpath->query($path);
        }
        if ($list === false) {
            throw new QueryEngineException(sprintf('Invalid XPath query: \'%s\', translated from: \'%s\'.', $path, $query));
        }

        if (!count($list)) {
            return null;
        }

        return $this->wrap($list->item(0));
    }

    /**
     * Evaluate a query
     * @param string
     * @param \Dogma\Dom\Element|\DOMNode
     * @return string|integer|float
     */
    public function evaluate($query, $context = null)
    {
        $path = $this->translateQuery($query, null);

        if ($context) {
            $value = $this->xpath->evaluate($path, $context);
        } else {
            $value = $this->xpath->evaluate($path);
        }
        if ($value === false) {
            throw new QueryEngineException(sprintf('Invalid XPath query: \'%s\', translated from: \'%s\'.', $path, $query));
        }

        if (substr($query, 0, 5) === 'date(') {
            return $value ? new \Dogma\Date($value) : null;

        } elseif (substr($query, 0, 9) === 'datetime(') {
            return $value ? new \Dogma\DateTime($value) : null;

        } elseif (substr($query, 0, 4) === 'int(') {
            if (!is_numeric($value)) {
                return null;
            }
            return (int) $value;

        } elseif (substr($query, 0, 5) === 'bool(' && isset($value)) {
            if ($value === '') {
                return null;
            }
            return (bool) $value;

        } else {
            return $value;
        }
    }

    /**
     * Extract values from paths defined by one or more queries
     * @param string|string[]
     * @param \Dogma\Dom\Element|\DOMNode
     * @return string|string[]
     */
    public function extract($queries, $context = null)
    {
        if (is_string($queries)) {
            return $this->extractPath($queries, $context);
        }

        $value = [];
        foreach ($queries as $i => $query) {
            if (is_array($query)) {
                $value[$i] = $this->extract($query, $context);
            } else {
                $value[$i] = $this->extractPath($query, $context);
            }
        }
        return $value;
    }

    // internals -------------------------------------------------------------------------------------------------------

    /**
     * @param string
     * @param \Dogma\Dom\Element|\DOMNode
     * @return string|integer|float|\DateTime|null
     */
    private function extractPath($query, $context)
    {
        if (Strings::match($query, '/^[a-zA-Z0-9_-]+\\(/')) {
            $node = $this->evaluate($query, $context);
        } else {
            $node = $this->findOne($query, $context);
        }

        if (is_scalar($node) || $node instanceof \DateTime) {
            return $node;

        } elseif (!$node) {
            return null;

        } elseif ($node instanceof \DOMAttr) {
            return $node->value;

        } elseif ($node instanceof \DOMText) {
            return $node->wholeText;

        } elseif ($node instanceof \DOMCdataSection || $node instanceof \DOMComment || $node instanceof \DOMProcessingInstruction) {
            return $node->data;

        } else {
            return $node->textContent;
        }
    }

    /**
     * Translates query to pure XPath syntax
     * @param string
     * @param boolean|null
     * @return string
     */
    private function translateQuery($query, $context = false)
    {
        if ($context === true) {
            if ($query[0] === '/') {
                $query = '.' . $query;
            } elseif ($query[0] !== '.') {
                $query = './/' . $query;
            }
        } elseif ($context === false) {
            if ($query[0] !== '/') {
                $query = '//' . $query;
            }
        }

        $query = Strings::replace($query, $this->translations);

        // adding ".//" before element names
        $query = Strings::replace($query, '@(?<=\\()([0-9A-Za-z_:]+)(?!\\()@', './/$1');

        // fixing ".//" before function names
        $query = Strings::replace($query, '@\\.//([0-9A-Za-z_:-]+)\\(@', '$1(');

        $nativeFunctions = $this->nativeFunctions;
        $userFunctions = $this->userFunctions;
        $query = Strings::replace(
            $query,
            '/(?<![A-Za-z0-9_-])([A-Za-z0-9_-]+)\\(/',
            function ($match) use ($nativeFunctions, $userFunctions) {
                if (in_array($match[1], $nativeFunctions)) {
                    return $match[1] . '(';

                } elseif (in_array($match[1], $userFunctions)) {
                    return sprintf('php:functionString(\'%s\', ', $match[1]);

                } else {
                    throw new \DOMException(sprintf('XPath compilation failure: Functions \'%s\' is not enabled.', $match[1]));
                }
            }
        );

        return $query;
    }

    /**
     * Wrap element in DomElement object
     * @param \DOMNode
     * @return \Dogma\Dom\Element|\DOMNode
     */
    private function wrap($node)
    {
        if ($node instanceof \DOMElement) {
            return new Element($node, $this);
        } else {
            return $node;
        }
    }

    // extension functions ---------------------------------------------------------------------------------------------

    /**
     * Test with regular expression and return matching string
     * @param string
     * @param string
     * @return string
     */
    public static function match($string, $pattern)
    {
        if ($m = Strings::match($string, $pattern)) {
            return $m[0];
        }

        return null;
    }

    /**
     * Replace substring with regular expression
     * @param string
     * @param string
     * @param string
     * @return string
     */
    public static function replace($string, $pattern, $replacement)
    {
        return Strings::replace($string, $pattern, $replacement);
    }

    /**
     * Format date in standard ISO format Y-m-d
     * @param string
     * @param string
     * @return string
     */
    public static function date($string, $format = 'Y-m-d')
    {
        if (!$string) {
            return '';
        }

        $date = \DateTime::createFromFormat($format, $string);
        if (!$date) {
            throw new QueryEngineException(
                sprintf('Cannot create DateTime object from \'%s\' using format \'%s\'.', $string, $format)
            );
        }

        return $date->format('Y-m-d');
    }

    /**
     * Format date in standard ISO format Y-m-d H:i:s
     * @param string
     * @param string
     * @return string
     */
    public static function datetime($string, $format = 'Y-m-d H:i:s')
    {
        if (!$string) {
            return '';
        }

        $date = \DateTime::createFromFormat($format, $string);
        if (!$date) {
            throw new QueryEngineException(
                sprintf('Cannot create DateTime object from \'%s\' using format \'%s\'.', $string, $format)
            );
        }

        return $date->format('Y-m-d H:i:s');
    }

    /**
     * Detect boolean value
     * @param string
     * @param string
     * @param string
     * @return boolean|null
     */
    public static function bool($string, $true = 'true', $false = 'false')
    {
        $string = strtoupper($string);
        if ($string === $false) {
            return 0;
        }
        if ($string === $true) {
            return 1;
        }

        return null;
    }

}
