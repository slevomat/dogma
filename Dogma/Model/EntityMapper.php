<?php
/**
 * This file is part of the Dogma library (https://github.com/paranoiq/dogma)
 *
 * Copyright (c) 2012 Vlasta Neubauer (@paranoiq)
 *
 * For the full copyright and license information read the file 'license.md', distributed with this source code
 */

namespace Dogma\Model;

/**
 * Maps database tables on entity classes. Creates entity instances from rows.
 */
class EntityMapper extends \Nette\Object {

    /** @var string[] (string $table => string $class) */
    private $map;

    /** @var \Dogma\Model\EntityFactory */
    private $factory;

    /** @var \Nette\DI\Container */
    private $context;


    /**
     * Set mapping of tables to classes (descendants of ActiveRow)
     * @param \Nette\DI\Container
     * @param string[] (string $table => class)
     */
    public function __construct(\Nette\DI\Container $context, array $map) {
        $this->map = $map;
        $this->context = $context;
        $this->factory = $context->getService('entityFactory');
    }


    /**
     * Translate table name to class name
     * @param string
     * @param \Nette\Database\Table\ActiveRow
     * @return \Dogma\Model\ActiveEntity
     */
    public function getInstance($table, $row) {
        if ($row === false)
            return false;

        if (array_key_exists($table, $this->map)) {
            $class = $this->map[$table];
            if (is_subclass_of($class, '\Dogma\Model\EntityRepository')) {
                $class = $this->context->getByType($class, true)->getEntityClass($row);
            }
        } else {
            $class = '\Dogma\Model\ActiveEntity';
        }

        return $this->context->createInstance($class, [$row]);
        //return $this->factory->createEntity($row, $class);
    }

}