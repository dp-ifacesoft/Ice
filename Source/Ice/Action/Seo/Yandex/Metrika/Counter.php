<?php

namespace Ice\Action;

use Ice\Core\Action;

class Seo_Yandex_Metrika_Counter extends Action
{
    /**
     * Action config
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
               'actions' => [],
               'input' => ['counterNumber' => ['validators' => 'Ice:Not_Empty']],
               'output' => [],
               'cache' => ['ttl' => -1, 'count' => 1000],
               'roles' => []
           ];
       }

      /** Run action
     *
     * @param  array $input
     * @return array
     *
     * @author anonymous <email>
     *
     * @version 0
     * @since   0
     */
    public function run(array $input)
    {
        return $input;
    }
}