<?php
/**
 * Ice core data source container abstract class
 *
 * @link http://www.iceframework.net
 * @copyright Copyright (c) 2014 Ifacesoft | dp <denis.a.shestakov@gmail.com>
 * @license https://github.com/ifacesoft/Ice/blob/master/LICENSE.md
 */

namespace Ice\Core;

use Ice;
use Ice\Core;
use Ice\Data\Provider\Mysqli as Data_Provider_Mysqli;
use Ice\Helper\Object;

/**
 * Class Data_Source
 *
 * Core data source container abstract class
 *
 * @see Ice\Core\Container
 *
 * @author dp <denis.a.shestakov@gmail.com>
 *
 * @package Ice
 * @subpackage Core
 *
 * @version stable_0
 * @since stable_0
 */
abstract class Data_Source extends Container
{
    /**
     * Data provider key for this data source
     *
     * @var string
     */
    private $_sourceDataProviderKey = null;

    /**
     * Connected data scheme
     *
     * @var string
     */
    private $_scheme = null;

    /**
     * Private constructor for dat source
     *
     * @param $scheme
     * @param $sourceDataProviderKey
     */
    private function __construct($scheme, $sourceDataProviderKey)
    {
        $this->_scheme = $scheme;
        $this->_sourceDataProviderKey = $sourceDataProviderKey;
        $this->getSourceDataProvider()->setScheme($scheme);
    }

    /**
     * Create new instance of data source
     *
     * @param $scheme
     * @param $hash
     * @return Data_Source
     */
    protected static function create($scheme, $hash = null)
    {
        $sourceDataProviderKey = Data_Source::getConfig()->get($scheme);
        $dataSourceClass = Object::getClass(Data_Source::getClass(), strstr($sourceDataProviderKey, '/', true));
        return new $dataSourceClass($scheme, $sourceDataProviderKey);
    }

    /**
     * Default key of data source
     *
     * @return string
     */
    public static function getDefaultKey()
    {
        $schemes = array_keys(Data_Source::getConfig()->gets());
        return reset($schemes);
    }

    /**
     * Execute query select to data source
     *
     * @param Query $query
     * @throws Exception
     * @return array
     */
    abstract public function select(Query $query);

    /**
     * Execute query insert to data source
     *
     * @param Query $query
     * @throws Exception
     * @return array
     */
    abstract public function insert(Query $query);

    /**
     * Execute query update to data source
     *
     * @param Query $query
     * @throws Exception
     * @return array
     */
    abstract public function update(Query $query);

    /**
     * Execute query update to data source
     *
     * @param Query $query
     * @throws Exception
     * @return array
     */
    abstract public function delete(Query $query);

    /**
     * Get connection instance
     *
     * @return Object
     */
    public function getConnection()
    {
        return $this->getSourceDataProvider()->getConnection();
    }

    /**
     * Return cache data provider
     *
     * @return Data_Provider
     */
    public function getCacheDataProvider()
    {
        return Data_Source::getInstance('cache');
    }

    /**
     * Return source data provider
     *
     * @return Data_Provider
     */
    public function getSourceDataProvider()
    {
        /** @var Data_Provider_Mysqli $sourceDataProvider */
        $sourceDataProvider = Data_Provider::getInstance($this->_sourceDataProviderKey);

        if ($sourceDataProvider->getScheme() != $this->_scheme) {
            $sourceDataProvider->setScheme($this->_scheme);
        }

        return $sourceDataProvider;
    }

    /**
     * Get data Scheme from data source
     *
     * @return array
     */
    public abstract function getTables();

    /**
     * Get table scheme from source
     *
     * @param $tableName
     * @return array
     */
    public abstract function getColumns($tableName);

    /**
     * Get current connected data scheme
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->_scheme;
    }
}