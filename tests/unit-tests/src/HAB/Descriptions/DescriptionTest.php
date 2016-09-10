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

use PHPUnit_Framework_TestCase as TestCase;

/**
 * Unit tests for the Description class.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class DescriptionTest extends TestCase
{
    public function testFilter ()
    {
        $desc = new Description();
        $desc->set('http://purl.org/dc/elements/1.1/title', 'Title');
        $desc->set('http://purl.org/dc/elements/1.1/subject', 'Subject');
        $desc->set('http://www.w3.org/2004/02/skos/core#prefLabel', 'Label');

        $iter = $desc->filter('http://www.w3.org/2004/02/skos/core#');
        $this->assertEquals(1, iterator_count($iter));
    }

    public function testAddCreatesArray ()
    {
        $desc = new Description();
        $desc->add('http://purl.org/dc/elements/1.1/title', 'Title');
        $this->assertInternalType('array', $desc->get('http://purl.org/dc/elements/1.1/title'));
    }

    public function testSetSingleValueCreatesArray ()
    {
        $desc = new Description();
        $desc->set('http://purl.org/dc/elements/1.1/title', 'Title');
        $this->assertInternalType('array', $desc->get('http://purl.org/dc/elements/1.1/title'));
    }

    public function testSetArray ()
    {
        $desc = new Description();
        $desc->set('http://purl.org/dc/elements/1.1/title', array('Title'));
        $title = $desc->get('http://purl.org/dc/elements/1.1/title');
        $this->assertInternalType('array', $title);
        $this->assertCount(1, $title);
        $this->assertInternalType('string', reset($title));
    }
}