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
 * Delegating description provider.
 *
 * @author    David Maus <maus@hab.de>
 * @copyright (c) 2016 by Herzog August Bibliothek Wolfenbüttel
 * @license   http://www.gnu.org/licenses/gpl.txt GNU General Public License v3 or higher
 */
class DelegatingDescriptionProvider implements DescriptionProviderInterface
{
    /**
     * Delegatees, indexed by type.
     *
     * @var array
     */
    private static $delegatees = array();

    /**
     * Add delegatee.
     *
     * @param  string            $type
     * @param  DescriptionProviderInterface $provider
     * @return void
     */
    public static function delegate ($type, DescriptionProviderInterface $provider)
    {
        if (!array_key_exists($type, self::$delegatees)) {
            self::$delegatees[$type] = array();
        }
        self::$delegatees[$type][] = $provider;
    }

    /**
     * {@inheritDoc}
     */
    public function describe (Resource $resource)
    {
        $types = (array)$resource->getDescription()->get('http://www.w3.org/1999/02/22-rdf-syntax-ns#type');
        if ($types) {
            foreach ($types as $name => $type) {
                if (array_key_exists($type, self::$delegatees)) {
                    foreach (self::$delegatees[$type] as $provider) {
                        $provider->describe($resource);
                    }
                }
            }
        }
    }
}