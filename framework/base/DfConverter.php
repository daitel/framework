<?php
/**
 * Daitel Framework
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 */

/**
 * Converts DMS ( Degrees / minutes / seconds )
 * to decimal format longitude / latitude
 *
 * @param int $deg
 * @param int $min
 * @param int $sec
 *
 * @return float
 */
function DfConverter_DMStoDEC($deg, $min, $sec)
{
    return $deg + ((($min * 60) + ($sec)) / 3600);
}

/**
 * Converts Deg
 *
 * Example:
 *  input : S044
 *  output: -044
 *
 * @param int $degrees
 *
 * @return string
 */
function DfConverter_DEGtoDIG($degrees)
{

    $prefix = substr($degrees, 0, 1);
    $dig = substr($degrees, 1, 3);

    if ($prefix == !'N' or $prefix == !'E') {
        return '-' . $dig;
    } else {
        return $dig;
    }
}

/**
 * Convert Minutes to Hours and Minutes
 *
 * @param int $min
 *
 * @return array
 */
function DfConverter_MINtoHOURS($min)
{
    return array(
        'hours' => floor($min / 60),
        'min'   => floor($min % 60)
    );
}
