<?php
/**
 * Ice action resources class
 *
 * @link      http://www.iceframework.net
 * @copyright Copyright (c) 2014 Ifacesoft | dp <denis.a.shestakov@gmail.com>
 * @license   https://github.com/ifacesoft/Ice/blob/master/LICENSE.md
 */

namespace Ice\Action;

use CSSmin;
use Ice\App;
use Ice\Core\Action;
use Ice\Core\Data_Provider;
use Ice\Core\Loader;
use Ice\Core\Module;
use Ice\Core\Request;
use Ice\Core\Route;
use Ice\Helper\Arrays;
use Ice\Helper\Directory;
use JSMin;

/**
 * Class Title
 *
 * Action of generation js and css for includes into html tag head (<script.. and <link..)
 *
 * @see Ice\Core\Action
 * @see Ice\Core\Action_Context
 *
 * @author dp <denis.a.shestakov@gmail.com>
 *
 * @package    Ice
 * @subpackage Action
 *
 * @version 0.0
 * @since   0.0
 */
class Resources extends Action
{
    /**
     * Runtime append js resource
     *
     * @param $resource
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since   0.0
     */
    public static function appendJs($resource)
    {
        self::append('js', $resource);
    }

    /**
     * Runtime append resource
     *
     * @param $resourceType
     * @param $resource
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since   0.0
     */
    private static function append($resourceType, $resource)
    {
        /**
         * @var Action $actionClass
         */
        $actionClass = self::getClass();

        $dataProvider = Data_Provider::getInstance($actionClass::getRegistryDataProviderKey());

        $customResources = $dataProvider->get($resourceType);

        if (!$customResources) {
            $customResources = [];
        }

        array_push($customResources, $resource);

        $dataProvider->set($resourceType, $customResources);
    }

    /**
     * Runtime append css resource
     *
     * @param $resource
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since   0.0
     */
    public static function appendCss($resource)
    {
        self::append('css', $resource);
    }

    /**
     * Action config
     *
     * example:
     * ```php
     *  $config = [
     *      'actions' => [
     *          ['Ice:Title', ['title' => 'page title'], 'title'],
     *          ['Ice:Another_Action, ['param' => 'value']
     *      ],
     *      'view' => [
     *          'layout' => Emmet::PANEL_BODY,
     *          'template' => _Custom,
     *          'viewRenderClass' => Ice:Twig,
     *      ],
     *      'input' => [
     *          Request::DEFAULT_DATA_PROVIDER_KEY => [
     *              'paramFromGETorPOST => [
     *                  'default' => 'defaultValue',
     *                  'validators' => ['Ice:PATTERN => PATTERN::LETTERS_ONLY]
     *                  'type' => 'string'
     *              ]
     *          ]
     *      ],
     *      'output' => ['Ice:Resource/Ice\Action\Index'],
     *      'ttl' => 3600,
     *      'roles' => []
     *  ];
     * ```
     *
     * @return array
     *
     * @author anonymous <email>
     *
     * @version 0
     * @since   0
     */
    protected static function config()
    {
        return [
            'view' => ['viewRenderClass' => 'Ice:Php', 'layout' => ''],
            'input' => [
                'resources' => [
                    'default' => [],
                ],
                'js' => ['default' => []],
                'css' => ['default' => []],
                'routeName' => ['providers' => 'router', 'default' => '/'],
                'context' => ['default' => '/resource/'],
            ],
            'ttl' => 3600
        ];
    }

    /**
     * Run action
     *
     * @param  array $input
     * @return array
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.6
     * @since   0.0
     */
    public function run(array $input)
    {
        $resources = [
            'js' => [],
            'css' => []
        ];

        $compiledResourceDir = Module::getInstance()->get('compiledResourceDir');

        foreach (array_keys(Module::getAll()) as $name) {
            $modulePath = Module::getInstance($name)->get('path');
            $jsResource = $compiledResourceDir . $name . '/javascript.pack.js';
            $cssResource = $compiledResourceDir . $name . '/style.pack.css';

            if (file_exists($jsSource = $modulePath . 'Resource/js/javascript.js')) {
                $resources['js'][] = [
                    'source' => $jsSource,
                    'resource' => $jsResource,
                    'url' => $input['context'] . $name . '/javascript.pack.js',
                    'pack' => true
                ];
            }
            if (file_exists($cssSource = $modulePath . 'Resource/css/style.css')) {
                $resources['css'][] = [
                    'source' => $cssSource,
                    'resource' => $cssResource,
                    'url' => $input['context'] . $name . '/style.pack.css',
                    'pack' => true,
                    'css_replace' => []
                ];
            }

            if (file_exists($imgSource = $modulePath . 'Resource/img')) {
                Directory::copy($imgSource, Directory::get($compiledResourceDir . 'img'));
            }
            if (file_exists($fontSource = $modulePath . 'Resource/font')) {
                Directory::copy($fontSource, Directory::get($compiledResourceDir . 'font'));
            }
            if (file_exists($apiSource = $modulePath . 'Resource/api')) {
                Directory::copy($apiSource, Directory::get($compiledResourceDir . 'api'));
            }
            if (file_exists($umlSource = $modulePath . 'Resource/uml')) {
                Directory::copy($umlSource, Directory::get($compiledResourceDir . 'uml'));
            }
            if (file_exists($docSource = $modulePath . 'Resource/doc')) {
                Directory::copy($docSource, Directory::get($compiledResourceDir . 'doc'));
            }
        }

        foreach ($input['resources'] as $from => $config) {
            foreach ($config as $name => $configResources) {
                foreach ($configResources as $resourceKey => $resourceItem) {
                    $source = $from == 'modules' // else from vendors
                        ? Module::getInstance($name)->get('path') . 'Resource/'
                        : VENDOR_DIR . $name . '/';

                    $res = $from == 'modules' // else from vendors
                        ? $name . '/' . $resourceKey . '/'
                        : 'vendor/' . $resourceKey . '/';

                    $resourceItemPath = is_array($resourceItem['path'])
                        ? reset($resourceItem['path'])
                        : $resourceItem['path'];

                    $source .= $resourceItemPath;

                    if ($resourceItem['isCopy']) {
                        Directory::copy($source, Directory::get($compiledResourceDir . $res));
                    }

                    $jsResource = $compiledResourceDir . $res . $resourceKey . '.pack.js';
                    $cssResource = $compiledResourceDir . $res . $resourceKey . '.pack.css';

                    foreach ($resourceItem['js'] as $resource) {
                        $resources['js'][] = [
                            'source' => $source . ltrim($resource, '-'),
                            'resource' => $jsResource,
                            'url' => $input['context'] . $res . $resourceKey . '.pack.js',
                            'pack' => $resource[0] != '-'
                        ];
                    }

                    $css_replace = isset($resourceItem['css_replace']) ? $resourceItem['css_replace'] : [];

                    foreach ($resourceItem['css'] as $resource) {
                        $resources['css'][] = [
                            'source' => $source . ltrim($resource, '-'),
                            'resource' => $cssResource,
                            'url' => $input['context'] . $res . $resourceKey . '.pack.css',
                            'pack' => $resource[0] != '-',
                            'css_replace' => $css_replace
                        ];
                    }
                }
            }
        }

        $moduleAlias = Module::getInstance()->getAlias();

        $jsRes = $moduleAlias . '/js/';
        $cssRes = $moduleAlias . '/css/';

        if (!Request::isCli()) {
            $resourceName = Route::getInstance($input['routeName'])->getName();

            $jsFile = $resourceName . '.pack.js';
            $cssFile = $resourceName . '.pack.css';

            $jsResource = Directory::get($compiledResourceDir . $jsRes) . $jsFile;
            $cssResource = Directory::get($compiledResourceDir . $cssRes) . $cssFile;

            $callStack = App::getContext()->getFullStack();

            foreach (array_keys($callStack) as $actionClass) {
                if (file_exists($jsSource = Loader::getFilePath($actionClass, '.js', MODULE::RESOURCE_DIR, false))) {
                    $resources['js'][] = [
                        'source' => $jsSource,
                        'resource' => $jsResource,
                        'url' => $input['context'] . $jsRes . $jsFile,
                        'pack' => true
                    ];
                }
                if (file_exists($cssSource = Loader::getFilePath($actionClass, '.css', MODULE::RESOURCE_DIR, false))) {
                    $resources['css'][] = [
                        'source' => $cssSource,
                        'resource' => $cssResource,
                        'url' => $input['context'] . $cssRes . $cssFile,
                        'pack' => true,
                        'css_replace' => []
                    ];
                }
            }
        }

        $jsFile = 'custom.pack.js';
        $cssFile = 'custom.pack.css';

        $jsResource = Directory::get($compiledResourceDir . $jsRes) . $jsFile;
        $cssResource = Directory::get($compiledResourceDir . $cssRes) . $cssFile;

        if (!empty($input['js'])) {
            foreach ($input['js'] as $resource) {
                $resources['js'][] =
                    [
                        'source' => Loader::getFilePath($resource, '.js', 'Resource/js/'),
                        'resource' => $jsResource,
                        'url' => $input['context'] . $jsRes . $jsFile,
                        'pack' => true
                    ];
            }
        }
        if (!empty($input['css'])) {
            foreach ($input['css'] as $resource) {
                $resources['css'][] =
                    [
                        'source' => Loader::getFilePath($resource, '.css', 'Resource/css/'),
                        'resource' => $cssResource,
                        'url' => $input['context'] . $cssRes . $cssFile,
                        'pack' => true,
                        'css_replace' => []
                    ];
            }
        }

        $this->pack($resources);

        return array(
            'js' => array_unique(Arrays::column($resources['js'], 'url')),
            'css' => array_unique(Arrays::column($resources['css'], 'url'))
        );
    }

    /**
     * Pack all resources in groupped files
     *
     * @param $resources
     *
     * @author dp <denis.a.shestakov@gmail.com>
     *
     * @version 0.0
     * @since   0.0
     */
    private function pack($resources)
    {
        if (!class_exists('JSMin', false) && !function_exists('jsmin')) {
            include_once VENDOR_DIR . 'mrclay/minify/min/lib/JSMin.php';

            /**
             * Custom implementation jsmin
             *
             * @param  $js
             * @return string
             */
            function jsmin($js)
            {
                return JSMin::minify($js);
            }
        }

        if (!class_exists('CSSMin', false)) {
            include_once VENDOR_DIR . 'mrclay/minify/min/lib/CSSmin.php';
        }
        $handlers = [];

        $CSSmin = new CSSMin();

        //        Debuger::dump($resources['css']);

        foreach ($resources['js'] as $resource) {
            if (!isset($handlers[$resource['resource']])) {
                Directory::get(dirname($resource['resource']));
                $handlers[$resource['resource']] = fopen($resource['resource'], 'w');
            }

            $pack = $resource['pack']
                ? jsmin(file_get_contents($resource['source']))
                : file_get_contents($resource['source']);

            fwrite($handlers[$resource['resource']], '/* Ice: ' . $resource['source'] . " */\n" . $pack . "\n\n\n");
        }

        foreach ($resources['css'] as $resource) {
            if (!isset($handlers[$resource['resource']])) {
                Directory::get(dirname($resource['resource']));
                $handlers[$resource['resource']] = fopen($resource['resource'], 'w');
            }

            $pack = $resource['pack']
                ? $CSSmin->run(file_get_contents($resource['source']))
                : file_get_contents($resource['source']);

            if (!empty($resource['css_replace'])) {
                $pack = str_replace($resource['css_replace'][0], $resource['css_replace'][1], $pack);
            }

            fwrite($handlers[$resource['resource']], '/* Ice: ' . $resource['source'] . " */\n" . $pack . "\n\n\n");
        }

        foreach ($handlers as $filePath => $handler) {
            fclose($handler);

//            chmod($filePath, 0664);
//            chgrp($filePath, filegroup(dirname($filePath)));
        }
    }
}
