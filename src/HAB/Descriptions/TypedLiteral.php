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
 * Typed literal value.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class TypedLiteral
{

    /**
     * Value.
     *
     * @var mixed
     */
    private $value;

    /**
     * Datatype.
     *
     * @var Resource
     */
    private $datatype;

    /**
     * Constructor.
     *
     * @param  mixed    $value
     * @param  Resource $datatype
     * @return void
     */
    public function __construct (Resource $datatype, $value)
    {
        $this->value = $value;
        $this->datatype = $datatype;
    }

    /**
     * Return value.
     *
     * @return mixed
     */
    public function getValue ()
    {
        return $this->value;
    }

    /**
     * Return datatype.
     *
     * @return Resource
     */
    public function getDatatype ()
    {
        return $this->datatype;
    }

    /**
     * Accept visitor.
     *
     * @param  VisitorInterface $visitor
     * @return void
     */
    public function accept (VisitorInterface $visitor)
    {
        $visitor->visitTypedLiteral($this);
    }

}