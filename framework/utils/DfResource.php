<?php
/**
 * DfResource is utils class
 *
 * DfResource class provide functions for work with resource files(CSS, JavaScript, Json arrays..)
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.utils
 * @since 0.1.6
 */
class DfResource
{
    /**
     * Resource data
     * In this array class collect all data about resource in this format
     *
     * @var array
     */
    public static $resource = [];

    /**
     * Set Data
     * @param string $type
     * @param string $data
     * @param bool $is_link
     * @param string $subType
     */
    public static function set($type = 'css', $data, $is_link = true, $subType = 'default')
    {
        self::$resource[$type][] = [
            'data' => $data,
            'is_link' => $is_link,
            'subType' => $subType
        ];
    }

    /**
     * Get Data
     * @param string $type
     * @param string $subType
     * @return string
     */
    public static function get($type, $subType = 'default')
    {
        $data = '';

        foreach (self::$resource[$type] as $res) {
            if ($res['subType'] == $subType) {
                switch ($type) {
                    case 'css':
                        $data .= self::getCss($res);
                        break;
                    case 'js':
                        $data .= self::getJs($res);
                        break;
                    default:
                        $data .= $res['data'];
                }
            }
        }

        return $data;
    }

    /**
     * Get CSS resource string
     * @param array $res
     * @return string
     */
    private static function getCss($res)
    {
        if ($res['is_link']) {
            return '<link href="' . $res['data'] . '" rel="stylesheet" type="text/css">' . "\n";
        } else {
            return "<style>" . $res['data'] . "</style>" . "\n";
        }
    }

    /**
     * Get Js resource string
     * @param array $res
     * @return string
     */
    private static function getJs($res)
    {
        $data = '<script';

        if ($res['is_link']) {
            $data .= ' src="' . $res['data'] . '">';
        } else {
            $data .= ">" . "\n" . $res['data'] . "\n";
        }

        $data .= "</script>" . "\n";

        return $data;
    }
}