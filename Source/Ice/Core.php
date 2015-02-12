<?php
/**
 * Ice common core trait
 *
 * @link http://www.iceframework.net
 * @copyright Copyright (c) 2014 Ifacesoft | dp <denis.a.shestakov@gmail.com>
 * @license https://github.com/ifacesoft/Ice/blob/master/LICENSE.md
 */

namespace Ice;

use Ice;
use Ice\Core\Code_Generator;
use Ice\Core\Config;
use Ice\Core\Data_Provider;
use Ice\Core\Environment;
use Ice\Core\Exception;
use Ice\Core\Logger;
use Ice\Core\Resource;
use Ice\Data\Provider\Registry;
use Ice\Data\Provider\Repository;
use Ice\Helper\Object;

/**
 * Trait Core
 *
 * Common static methods for containers or others
 *
 * @author dp <denis.a.shestakov@gmail.com>
 *
 * @package Ice
 *
 * @version 0.0
 * @since 0.0
 */
trait Core
{
    /**
     * Return short name of class (Ice:Class_Name)
     *
     * @return string
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getShortName()
    {
        return Object::getShortName(self::getClass());
    }

    /**
     * Return class by base class
     *
     * @param string|null $className
     * @return Core
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getClass($className = null)
    {
        return empty($className)
            ? get_called_class()
            : Object::getClass(get_called_class(), $className);
    }

    /**
     * Get module name of object
     *
     * 'Ice/Model/Ice/User' => 'Ice'
     *
     * @return string
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getModuleAlias()
    {
        return Object::getModuleAlias(self::getClass());
    }

    /**
     * Return instance of resource for self class
     *
     * @return Resource
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getResource()
    {
        return Resource::create(self::getClass());
    }

    /**
     * Return config of self class
     *
     * @param null $postfix
     * @return Config
     * @throws Exception
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getConfig($postfix = null)
    {
        return Config::create(self::getClass(), $postfix);
    }

    /**
     * Return dat provider for self class
     *
     * @param string|null $postfix
     * @return Data_Provider
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getDataProvider($postfix = null)
    {
        if (empty($postfix)) {
            $postfix = strtolower(self::getClassName());
        }

        return Environment::getInstance()->getProvider(self::getBaseClass(), $postfix);
    }

    /**
     * Return class name (without namespace)
     *
     * @return string
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getClassName()
    {
        return Object::getName(self::getClass());
    }

    /**
     * Return base class for self class (class extends Container)
     *
     * @return Core
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getBaseClass()
    {
        return Object::getBaseClass(self::getClass());
    }

    /**
     * Return code generator for self class type
     *
     * @return Code_Generator
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getCodeGenerator()
    {
        return Code_Generator::getInstance(self::getClass());
    }

    /**
     * Return namespace by base class
     *
     * @return string
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getNamespace()
    {
        return Object::getNamespace(self::getBaseClass(), self::getClass());
    }

    /**
     * Return logger for self class
     *
     * @return Logger
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getLogger()
    {
        return Logger::getInstance(self::getClass());
    }

    /**
     * Return registry storage for  class
     *
     * @return Registry
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getRegistry()
    {
        return Registry::getInstance(self::getClass());
    }

    /**
     * Return repository storage for  class
     *
     * @return Repository
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.4
     * @since 0.4
     */
    public static function getRepository()
    {
        return Repository::getInstance(self::getClass());
    }
}