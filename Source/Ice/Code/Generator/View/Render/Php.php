<?php
/**
 * Ice code generator implementation php view class
 *
 * @link http://www.iceframework.net
 * @copyright Copyright (c) 2014 Ifacesoft | dp <denis.a.shestakov@gmail.com>
 * @license https://github.com/ifacesoft/Ice/blob/master/LICENSE.md
 */

namespace Ice\Code\Generator;

use Ice\Core\Code_Generator;
use Ice\Core\Loader;
use Ice\Core\Logger;
use Ice\Core\Model as Core_Model;
use Ice\Helper\File;
use Ice\Helper\Object;
use Ice\View\Render\Php;

/**
 * Class View_Render_Php
 *
 * View code generator for php templates
 *
 * @see Ice\Core\Code_Generator
 *
 * @author dp <denis.a.shestakov@gmail.com>
 *
 * @package Ice
 * @subpackage Code_Generator
 *
 * @version stable_0
 * @since stable_0
 */
class View_Render_Php extends Code_Generator
{
    /**
     * Generate code and other
     *
     * @param array $data Sended data requered for generate
     * @param bool $force Force if already generate
     * @return mixed
     */
    public function generate($data, $force = false)
    {
        $class = Object::getClass(Action::getClass(), $data);
        $namespace = Object::getNamespace(Action::getClass(), $class);

        $path = $namespace ? 'Resource/' : 'Resource/Class/';

        $filePath = Loader::getFilePath($class, Php::TEMPLATE_EXTENTION, $path, false, true, true);

        $isFileExists = file_exists($filePath);

        if (!$force && $isFileExists) {
            Code_Generator::getLogger()->info(['Template {$0} {$1} already created', ['Php', $class]]);
            return '';
        }

        $classString = Php::getInstance()->fetch(__CLASS__, []);

        File::createData($filePath, $classString, false);

        $message = $isFileExists
            ? 'Template {$0} {$1}" recreated'
            : 'Template {$0} {$1}" created';

        if ($isFileExists) {
            Code_Generator::getLogger()->info([$message, ['Php', $class]], Logger::SUCCESS);
        }

        return $classString;
    }
}