<?php
/**
 * Ice helper route class
 *
 * @link http://www.iceframework.net
 * @copyright Copyright (c) 2014 Ifacesoft | dp <denis.a.shestakov@gmail.com>
 * @license https://github.com/ifacesoft/Ice/blob/master/LICENSE.md
 */

namespace Ice\Helper;

/**
 * Class Route
 *
 * Helper for routes
 *
 * @author dp <denis.a.shestakov@gmail.com>
 *
 * @package Ice
 * @subpackage Helper
 *
 * @version stable_0
 * @since stable_0
 */
class Route
{
    /**
     * Set defaults route data
     *
     * @param array $route
     * @return array
     */
    public static function setDefaults(array $route)
    {
        return array_merge(self::getDefaults(), $route);
    }

    /**
     * Return default route data
     *
     * @return array
     */
    public static function getDefaults()
    {
        return [
            'params' => [],
            'weight' => 0,
        ];
    }
} 