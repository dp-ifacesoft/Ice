<?php
namespace Ice\Helper;

use Ice\Core\Query_Builder;
use Ice\Core\Request as Core_Request;

class Request
{
    public static function getPaginationParams(array $params)
    {
        return array_merge(Core_Request::getParams(['page', 'limit']), $params);
    }

//    public static function getOrderParams(array $params)
//    {
//        $orderParams = [];
//
//        $ascPattern = '/(?:[^\/]+\/)?' . Query_Builder::SQL_ORDERING_ASC . '$/';
//        $descPattern = '/(?:[^\/]+\/)?' . Query_Builder::SQL_ORDERING_DESC . '$/';
//
//        foreach (Core_Request::getParams($params) as $name => $value) {
//            if (!$value) {
//                $orderParams[$name] = '';
//            }
//
//            if (preg_match($ascPattern, $value)) {
//                $orderParams[$name] = Query_Builder::SQL_ORDERING_ASC;
//            } elseif (preg_match($descPattern, $value)) {
//                $orderParams[$name] = Query_Builder::SQL_ORDERING_DESC;
//            } else {
//                $orderParams[$name] = '';
//            }
//        }
//
//        return $orderParams;
//    }

//    public static function getFilterParams($params)
//    {
//        $filterParams = [];
//
//        $checkAsc = '/' . Query_Builder::SQL_ORDERING_ASC;
//        $checkDesc = '/' . Query_Builder::SQL_ORDERING_DESC;
//
//        foreach (Core_Request::getParams($params) as $name => $value) {
//            if (strlen($value) < strlen($checkAsc)) {
//                $filterParams[$name] = $value;
//                continue;
//            }
//
//            if (substr($value, -strlen($checkAsc)) == $checkAsc) {
//                $filterParams[$name] = strstr($value, $checkAsc, true);
//                continue;
//            }
//
//            if (strlen($value) > strlen($checkAsc) && strtoupper(substr($value, -strlen($checkDesc))) == $checkDesc) {
//                $filterParams[$name] = strstr($value, $checkDesc, true);
//                continue;
//            }
//
//            $filterParams[$name] = $value;
//        }
//
//        return $filterParams;
//    }
}
