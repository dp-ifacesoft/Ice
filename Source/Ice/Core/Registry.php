<?php
/**
 * Ice core registry class
 *
 * @link http://www.iceframework.net
 * @copyright Copyright (c) 2014 Ifacesoft | dp <denis.a.shestakov@gmail.com>
 * @license https://github.com/ifacesoft/Ice/blob/master/LICENSE.md
 */

namespace Ice\Core;

use Ice\Data\Provider\Registry as Data_Provider_Registry;

/**
 * Class Registry
 *
 * Core registry class
 *
 * @author dp <denis.a.shestakov@gmail.com>
 *
 * @package Ice
 * @subpackage Core
 *
 * @version stable_0
 * @since stable_0
 */
class Registry
{
    const DEFAULT_DATA_PROVIDER_KEY = 'Registry:registry/';

    /**
     * Return data from registry by key
     *
     * @param $key
     * @return mixed
     */
    public static function get($key)
    {
        return Data_Provider_Registry::getInstance()->get($key);
    }

    /**
     * Set new value into registry
     *
     * @param $key
     * @param $value
     */
    public static function set($key, $value)
    {
        Data_Provider_Registry::getInstance()->set($key, $value);
    }
}