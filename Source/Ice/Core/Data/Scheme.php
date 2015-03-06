<?php
/**
 * Ice core data scheme container class
 *
 * @link http://www.iceframework.net
 * @copyright Copyright (c) 2014 Ifacesoft | dp <denis.a.shestakov@gmail.com>
 * @license https://github.com/ifacesoft/Ice/blob/master/LICENSE.md
 */

namespace Ice\Core;

use Ice;
use Ice\Core;
use Ice\Helper\Directory;
use Ice\Helper\Json;
use Ice\Helper\Php;
use Ice\Helper\String;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

/**
 * Class Data_Scheme
 *
 * Core data scheme container class
 *
 * @see Ice\Core\Container
 *
 * @author dp <denis.a.shestakov@gmail.com>
 *
 * @package Ice
 * @subpackage Core
 */
class Data_Scheme
{
    use Core;

    /**
     * Data source key
     *
     * @var string
     */
    private $_dataSourceKey = null;

    private $_tables = null;

    /**
     * Private constructor of dat scheme
     *
     * @param $dataSourceKey
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since 0.0
     */
    private function __construct($dataSourceKey)
    {
        $this->_dataSourceKey = $dataSourceKey;
    }

    /**
     * Create new instance of data scheme
     *
     * @param $dataSourceKey
     * @return Data_Scheme
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.4
     * @since 0.0
     */
    public static function create($dataSourceKey)
    {
        return new Data_Scheme($dataSourceKey);
    }
//
//    /**
//     * Return default scheme name
//     *
//     * @return string
//     *
//     * @author dp <denis.a.shestakov@gmail.com>
//     *
//     * @version 0.0
//     * @since 0.0
//     */
//    protected static function getDefaultKey()
//    {
//        $schemes = array_keys(Data_Source::getConfig()->gets());
//        return reset($schemes);
//    }
//
//    /**
//     * Return map tables short scheme
//     *
//     * @return array
//     *
//     * @author dp <denis.a.shestakov@gmail.com>
//     *
//     * @version 0.0
//     * @since 0.0
//     */
//    public function getTableNames()
//    {
//        return $this->_dataScheme['tables'];
//    }
//
//    /**
//     * Return map of model classes and their table names
//     *
//     * @return Model[]
//     *
//     * @author dp <denis.a.shestakov@gmail.com>
//     *
//     * @version 0.0
//     * @since 0.0
//     */
//    public function getModelClasses()
//    {
//        if ($this->_modelClasses !== null) {
//            return $this->_modelClasses;
//        }
//
//        return $this->_modelClasses = array_flip(Arrays::column($this->getTableNames(), 'modelClass'));
//    }
//
//    /**
//     * Return current scheme name
//     *
//     * @return string
//     *
//     * @author dp <denis.a.shestakov@gmail.com>
//     *
//     * @version 0.0
//     * @since 0.0
//     */
//    public function getName()
//    {
//        return $this->_dataScheme['scheme'];
//    }

    /**
     * Return tables
     *
     * @return array
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.5
     * @since 0.5
     */
    public function getTables(Module $module)
    {
        if ($this->_tables !== null) {
            return $this->_tables;
        }

        $this->_tables = [];

        $sourceDir = MODULE_DIR . 'Source/';

        $Directory = new RecursiveDirectoryIterator(Directory::get($sourceDir . $module->getAlias() . '/Model'));
        $Iterator = new RecursiveIteratorIterator($Directory);
        $Regex = new RegexIterator($Iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

        foreach ($Regex as $filePathes) {
            $modelPath = reset($filePathes);
            $classNames = Php::file_get_php_classes($modelPath);
            $modelName = reset($classNames);

            $modelClass = str_replace('/', '\\', substr($modelPath, strlen($sourceDir), -4 - strlen($modelName))) . $modelName;

            $config = $modelClass::getConfig()->gets();

            if ($module->checkTableByPrefix($config['scheme']['tableName'], $this->getKey() . '.' . $this->getScheme())) {
                $config['modelClass'] = $modelClass;
                $config['modelPath'] = substr($modelPath, strlen($sourceDir));
                $this->_tables[$config['scheme']['tableName']] = $config;
            }
        }

        return $this->_tables;
    }

    /**
     * Return data scheme (source) key
     *
     * @return string
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.5
     * @since 0.5
     */
    public function getDataSourceKey()
    {
        return $this->_dataSourceKey;
    }
//
//    /**
//     * Return data scheme revision
//     *
//     * @return string
//     *
//     * @author dp <denis.a.shestakov@gmail.com>
//     *
//     * @version 0.5
//     * @since 0.5
//     */
//    public function getRevision()
//    {
//        return $this->_dataScheme['revision'];
//    }
//
//    /**
//     * Return data scheme
//     *
//     * @return array
//     *
//     * @author dp <denis.a.shestakov@gmail.com>
//     *
//     * @version 0.5
//     * @since 0.5
//     */
//    public function getDataScheme()
//    {
//        return $this->_dataScheme;
//    }
//
//    /**
//     * Return model scheme by table name
//     *
//     * @param $tableName
//     * @return Model_Scheme
//     *
//     * @author dp <denis.a.shestakov@gmail.com>
//     *
//     * @version 0.5
//     * @since 0.5
//     */
//    public function getModelScheme($tableName)
//    {
//        return Model_Scheme::create($this->getModelClass($tableName));
//    }
//
//    /**
//     * Return model class by table name
//     *
//     * @param $tableName
//     * @return Model
//     *
//     * @author dp <denis.a.shestakov@gmail.com>
//     *
//     * @version 0.5
//     * @since 0.5
//     */
//    public function getModelClass($tableName)
//    {
//        return isset($this->getTables()[$tableName])
//            ? $this->getTables()[$tableName]['modelClass']
//            : Helper_Model::getModelClassByTableName($tableName);
//    }

    /**
     * Return data source
     *
     * @return Data_Source
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.5
     * @since 0.5
     */
    public function getDataSource()
    {
        return Data_Source::getInstance($this->getDataSourceKey());
    }

    public function update($force = false)
    {
        $dataSource = $this->getDataSource();

        $module = Module::getInstance();

        $dataSchemeTables = $this->getTables($module);

        foreach ($dataSource->getTables($module) as $tableName => $table) {
            if (!isset($dataSchemeTables[$tableName])) {
                $modelClass = $module->getModelClass($tableName, $dataSource->getKey() . '.'  . $dataSource->getScheme());
                Model::getCodeGenerator()->generate($modelClass, $table, $force);
                Data_Scheme::getLogger()->info(['Create model {$0}', $modelClass]);
                continue;
            }

            $temp = $table;
            $updated = false;

            $tableSchemeHash = &$dataSchemeTables[$tableName]['schemeHash'];
            $tableScheme = &$dataSchemeTables[$tableName]['scheme'];

            if ($table['schemeHash'] != $tableSchemeHash) {
                Data_Scheme::getLogger()->info(['Update scheme for model {$0}: {$1}', [$dataSchemeTables[$tableName]['modelClass'], Json::encode(array_diff($table['scheme'], $tableScheme))]]);
                $tableScheme = $table['scheme'];
                $tableSchemeHash = $table['schemeHash'];
                $updated = true;
            }

            $tableIndexesHash = &$dataSchemeTables[$tableName]['indexesHash'];
            $tableIndexes = &$dataSchemeTables[$tableName]['indexes'];

            if ($table['indexesHash'] != $tableIndexesHash) {
                Data_Scheme::getLogger()->info(['Update indexes for model {$0}: {$1}', [$dataSchemeTables[$tableName]['modelClass'], Json::encode(array_diff($table['indexes'], $tableIndexes))]]);
                $tableIndexes = $table['indexes'];
                $tableIndexesHash = $table['indexesHash'];
                $updated = true;
            }

            $dataSchemeColumns = $dataSchemeTables[$tableName]['columns'];

            foreach ($table['columns'] as $columnName => $column) {
                if (!isset($dataSchemeTables[$tableName]['columns'][$columnName])) {
                    $dataSchemeTables[$tableName]['columns'][$columnName] = [
                        'scheme' => $column['scheme'],
                        'schemeHash' => $column['schemeHash']
                    ];
                    Data_Scheme::getLogger()->info(['Create field {$0} for model {$1}', [$column['fieldName'], $dataSchemeTables[$tableName]['modelClass']]]);
                    $updated = true;
                    continue;
                }

                $columnSchemeHash = &$dataSchemeTables[$tableName]['columns'][$columnName]['schemeHash'];
                $columnScheme = &$dataSchemeTables[$tableName]['columns'][$columnName]['scheme'];

                if ($column['schemeHash'] != $columnSchemeHash) {
                    Data_Scheme::getLogger()->info(['Update field {$0} for model {$1}: {$2}', [$column['fieldName'], $dataSchemeTables[$tableName]['modelClass'], Json::encode(array_diff($column['scheme'], $columnScheme))]]);
                    $columnScheme = $column['scheme'];
                    $columnSchemeHash = $column['schemeHash'];
                    $updated = true;
                }

                unset($dataSchemeColumns[$columnName]);
            }

            foreach ($dataSchemeColumns as $columnName => $column) {
                Data_Scheme::getLogger()->info(['Remove field {$0} for model {$1}', [$column['fieldName'], $dataSchemeTables[$tableName]['modelClass']]]);
                unset($dataSchemeTables[$tableName]['columns'][$columnName]);
                $updated = true;
            }

            if ($updated) {
                Model::getCodeGenerator()->generate($dataSchemeTables[$tableName]['modelClass'], $table, $force);
            }

            unset($dataSchemeTables[$tableName]);
        }

        foreach ($dataSchemeTables as $tableName => $table) {
            Data_Scheme::getLogger()->info(['Remove model {$0}', $dataSchemeTables[$tableName]['modelClass']]);
            unlink(MODULE_DIR . 'Source/' . $table['modelPath']);
        }
    }

    public function getScheme()
    {
        return substr($this->_dataSourceKey, strpos($this->_dataSourceKey, '.') + 1);
    }

    public function getKey()
    {
        return strstr(substr($this->_dataSourceKey, strpos($this->_dataSourceKey, '/') + 1), '.', true);
    }
//
//    public function getTableName($modelClass)
//    {
//        foreach ($this->getTables() as $tableName => $table) {
//            if ($table['modelClass'] == $modelClass) {
//                return $tableName;
//            }
//        }
//
//        Data_Scheme::getLogger()->exception(
//            [
//                'Table name not found for class {$0} in data scheme {$1}',
//                [$modelClass, $this->getDataSourceKey()]
//            ],
//            __FILE__, __LINE__, null, null, -1, 'Ice:Data_Scheme_Error'
//        );
//
//        return null;
//    }
}