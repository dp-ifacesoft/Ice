<?php
/**
 * Ice code generator implementation smarty view class
 *
 * @link      http://www.iceframework.net
 * @copyright Copyright (c) 2014 Ifacesoft | dp <denis.a.shestakov@gmail.com>
 * @license   https://github.com/ifacesoft/Ice/blob/master/LICENSE.md
 */

namespace Ice\Code\Generator;

use Ice\Core\Code_Generator;
use Ice\Core\Logger;
use Ice\Core\Module;
use Ice\Helper\File;
use Ice\Helper\Object;
use Ice\View\Render\Php;
use Ice\View\Render\Smarty;

/**
 * Class View_Render_Smarty
 *
 * View code generator for smarty templates
 *
 * @see Ice\Core\Code_Generator
 *
 * @author dp <denis.a.shestakov@gmail.com>
 *
 * @package    Ice
 * @subpackage Code_Generator
 *
 * @version 0.0
 * @since   0.0
 */
class View_Render_Smarty extends Code_Generator
{
    /**
     * Generate code and other
     *
     * @param  $class
     * @param  array $data Sended data requered for generate
     * @param  bool $force Force if already generate
     * @return mixed
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since   0.0
     */
    public function generate($class, array $data = [], $force = false)
    {
        $module = Module::getInstance(Object::getModuleAlias($class));

        $path = $module->get(Module::RESOURCE_DIR);

        //        if ($namespace) {
        //            $path .= 'Class/';
        //        }

        $filePath = $path . str_replace(['\\', '_'], '/', $class) . Smarty::TEMPLATE_EXTENTION;

        $isFileExists = file_exists($filePath);

        if (!$force && $isFileExists) {
            Code_Generator::getLogger()->info(['Template {$0} {$1} already created', ['Smarty', $class]]);
            return file_get_contents($filePath);
        }

        $classString = Php::getInstance()->fetch(__CLASS__, []);

        File::createData($filePath, $classString, false);

        $message = $isFileExists
            ? 'Template {$0} {$1}" recreated'
            : 'Template {$0} {$1}" created';

        if ($isFileExists) {
            Code_Generator::getLogger()->info([$message, ['Smarty', $class]], Logger::SUCCESS);
        }

        return $classString;
    }
}
