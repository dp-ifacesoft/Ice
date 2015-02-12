<?php
/**
 * Ice core environment class
 *
 * @link http://www.iceframework.net
 * @copyright Copyright (c) 2014 Ifacesoft | dp <denis.a.shestakov@gmail.com>
 * @license https://github.com/ifacesoft/Ice/blob/master/LICENSE.md
 */

namespace Ice\Core;

use Ice\Core;
use Ice\Data\Provider\Repository;
use Ice\Helper\Config as Helper_Config;

/**
 * Class Environment
 *
 * Core environment class
 *
 * @see Ice\Core\Container
 *
 * @author dp <denis.a.shestakov@gmail.com>
 *
 * @package Ice
 * @subpackage Core
 *
 * @version 0.0
 * @since 0.0
 */
class Environment extends Container
{
    use Core;

    const PRODUCTION = 'production';
    const TEST = 'test';
    const DEVELOPMENT = 'development';

    /**
     * Environment config params
     *
     * @var array
     */
    private $_params = null;

    /**
     * Environment name (production|test|development)
     *
     * @var string
     */
    private $_environment = null;

    /**
     * Protected constructor of environment object
     *
     * @param $environment string Name of environment (production|test|development)
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    protected function __construct($environment)
    {
        $this->_environment = $environment;

        $settings = [];

        foreach (Environment::getConfig()->gets() as $env => $data) {
            if ($env == 'environments') {
                continue;
            }

            $settings = array_merge_recursive($data, $settings);
            if ($env == $environment) {
                break;
            }
        }

        $this->_params = $settings;
    }

    public static function getInstance($key = null, $ttl = null) {
        if (!$key) {
            $key = Environment::getDefaultKey();
        }

        /** @var Data_Provider $dataProvider */
        $dataProvider = Data_Provider::getInstance(Environment::getDefaultDataProviderKey());

        if ($_config = $dataProvider->get($key)) {
            return $_config;
        }

        return $dataProvider->set($key, new Environment($key));
    }

    /**
     * Return data provider
     *
     * @param string|null $postfix Specific data provider key ($data_provider_key . '_prefix')
     * @return Data_Provider
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function getDataProvider($postfix = null)
    {
        return Data_Provider::getInstance(self::getDefaultDataProviderKey());
    }

    /**
     * Return default data provider key
     *
     * @return string
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    protected static function getDefaultDataProviderKey()
    {
        return 'Ice:Registry/' . __CLASS__;
    }


    /**
     * Check to current environment is development
     *
     * @return bool
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function isDevelopment()
    {
        return self::getInstance()->getEnvironment() == self::DEVELOPMENT;
    }

    /**
     * Check to current environment is development
     *
     * @return bool
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public static function isProduction()
    {
        return Environment::getInstance()->getEnvironment() == self::PRODUCTION;
    }

    /**
     * Return default key of data provider
     *
     * @return string
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    protected static function getDefaultKey()
    {
        $host = Request::host();

        foreach (Environment::getConfig()->gets('environments') as $hostPattern => $environment) {
            $matches = [];
            preg_match($hostPattern, $host, $matches);

            if (!empty($matches)) {
                return $environment;
            }
        }

        return self::PRODUCTION;
    }

    /**
     * Create new instance of environment
     *
     * @param string $environment Name of environment (production|test|devlepment)
     *
     * @return Environment
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    protected static function create($environment)
    {
        return new Environment($environment);
    }

    /**
     * Retern Data Provider by class name
     *
     * @param string $class Class (found data provider for this class)
     * @param string $index Index of data provider
     * @return Data_Provider
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public function getProvider($class, $index)
    {
        return Data_Provider::getInstance($this->getDataProviderKey($class, $index), $index);
    }

    /**
     * Return data provider key by class name
     *
     * @param $class
     * @param  $index
     * @throws Exception
     * @return string
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public function getDataProviderKey($class, $index)
    {
        $key = 'dataProviderKeys/' . $class . '/' . $index;

        $dataProviderKey = $this->get($key);

        if ($dataProviderKey === null) {
            Environment::getLogger()->exception(['In environment config param {$0} not found', $key], __FILE__, __LINE__);
        }

        return is_array($dataProviderKey)
            ? reset($dataProviderKey)
            : $dataProviderKey;
    }

    /**
     * Environment config param value (one (first) value)
     *
     * @param string|null $key
     * @param bool $isRequired
     * @throws Exception
     * @return string
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.4
     * @since 0.0
     */
    public function get($key = null, $isRequired = true)
    {
        $params = $this->gets($key, $isRequired);

        return empty($params) ? null : reset($params);
    }

    /**
     * Environment config param values
     *
     * @param string|null $key
     * @param bool $isRequired
     * @return array
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.4
     * @since 0.0
     */
    public function gets($key = null, $isRequired = true)
    {
        return Helper_Config::gets($this->_params, $key, $isRequired);
    }

    /**
     * Return current environment name
     *
     * @return string
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    public function getEnvironment()
    {
        return $this->_environment;
    }
}