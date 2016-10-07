<?php

/**
 * This file is part of HAB Descriptions.
 *
 * HAB Descriptions is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * HAB Descriptions is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with HAB Descriptions.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */

namespace HAB\Descriptions;

use CallbackFilterIterator;
use IteratorAggregate;
use ArrayIterator;
use Iterator;

/**
 * Resource description.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class Description implements IteratorAggregate
{
    /**
     * Properties, indexed by URI.
     *
     * @var array
     */
    private $properties = array();

    /**
     * Described resource.
     *
     * @var Resource
     */
    private $resource;

    /**
     * Constructor.
     *
     * @param  Resource $resource
     * @return void
     */
    public function __construct (Resource $resource = null)
    {
        $this->resource = $resource;
    }

    /**
     * Add property.
     *
     * @param  string $property
     * @param  mixed  $value
     * @return void
     */
    public function add ($property, $value)
    {
        $key = (string)$property;
        if (!array_key_exists($key, $this->properties)) {
            $this->properties[$key] = array();
        }
        $this->properties[$key][] = $value;
    }

    /**
     * Set property.
     *
     * @param  string $property
     * @param  mixed  $value
     * @return void
     */
    public function set ($property, $value)
    {
        $key = (string)$property;
        $this->properties[$key] = (array)$value;
    }

    /**
     * Return property.
     *
     * @param  string $property
     * @return array
     */
    public function get ($property)
    {
        $key = (string)$property;
        if (array_key_exists($key, $this->properties)) {
            return $this->properties[$key];
        }
        return array();
    }

    /**
     * Return true if description has property.
     *
     * @param  string $property
     * @return boolean
     */
    public function has ($property)
    {
        $key = (string)$property;
        if (array_key_exists($key, $this->properties) && !empty($this->properties[$key])) {
            return true;
        }
        return false;
    }

    /**
     * Return iterator for properties starting with prefix.
     *
     * @param  string $prefix
     * @return Iterator
     */
    public function filter ($prefix)
    {
        $callback = function ($values, $property, $iterator) use ($prefix) {
            return (strpos($property, $prefix) === 0);
        };
        $iterator = $this->getIterator();
        return new CallbackFilterIterator($iterator, $callback);
    }

    /**
     * Return described resource, if any.
     *
     * @return Resource|null
     */
    public function getResource ()
    {
        return $this->resource;
    }

    /**
     * {@inheritDoc}
     */
    public function getIterator ()
    {
        return new ArrayIterator($this->properties);
    }

    /**
     * Merge another description.
     *
     * @param  Description|Traversable|array $description
     * @return void
     */
    public function merge ($description)
    {
        foreach ($description as $name => $value) {
            $this->add($name, $value);
        }
    }
    
    /**
     * Accept visitor.
     *
     * @param  VisitorInterface $visitor
     * @return void
     */
    public function accept (VisitorInterface $visitor)
    {
        $visitor->visitDescription($this);
    }

}