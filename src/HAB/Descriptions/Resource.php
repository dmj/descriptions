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

/**
 * Resource singleton.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class Resource
{
    /**
     * Resources, indexed by URI.
     *
     * @var array
     */
    private static $resources = array();

    /**
     * Resource identifier.
     *
     * @var string
     */
    private $identifier;

    /**
     * Resource description.
     *
     * @var Description
     */
    private $description;

    /**
     * Representation, if any.
     *
     * @var mixed
     */
    private $representation;

    /**
     * Label.
     *
     * @var string
     */
    private $label;

    /**
     * Return resource instance.
     *
     * @param  string $uri
     * @return self
     */
    public static function get ($uri)
    {
        if (!array_key_exists($uri, self::$resources)) {
            self::$resources[$uri] = new Resource($uri);
        }
        return self::$resources[$uri];
    }

    /**
     * Constructor.
     *
     * @param  string $identifier
     * @return void
     */
    private function __construct ($identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Return associated description.
     *
     * @return Description
     */
    public function getDescription ()
    {
        if (is_null($this->description)) {
            $this->description = new Description($this);
        }
        return $this->description;
    }

    /**
     * Return resource identifier.
     *
     * @return string
     */
    public function getIdentifier ()
    {
        return $this->identifier;
    }

    /**
     * Return label, if any.
     *
     * @return string
     */
    public function getLabel ()
    {
        return $this->label;
    }

    /**
     * Set label.
     *
     * @param  string $label
     * @return void
     */
    public function setLabel ($label)
    {
        $this->label = $label;
    }

    /**
     * Set resource representation.
     *
     * @param  mixed $representation
     * @return void
     */
    public function setRepresentation ($representation)
    {
        $this->representation = $representation;
    }

    /**
     * Return representation.
     *
     * @return mixed
     */
    public function getRepresentation ()
    {
        return $this->representation;
    }

    /**
     * Return string representation.
     *
     * @return string
     */
    public function __toString ()
    {
        return $this->getIdentifier();
    }
}