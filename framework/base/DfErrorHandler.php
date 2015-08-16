<?php
/**
 * DfErrorHandler is a handling class for errors and exceptions
 *
 * DfErrorHandler provide functions for debug and view errors and exceptions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @package system.base
 */
class DfErrorHandler
{
    /**
     *
     * @var bool
     */
    private static $highlightSet = false;

    /**
     * renderExceptionPage
     * @param DfException $ex
     */
    public static function renderExceptionPage($ex)
    {
        include DfApp::getRuntimePath(true) . "framework/views/errors/exception.php";
    }

    /**
     * showSources
     * This function make html code from sources
     * @param string $path
     * @param bool $showAll
     * @param int $highlight
     * @param int $linesBeforeAndAfter
     */
    public static function showSources($path, $showAll = false, $highlight = 0, $linesBeforeAndAfter = 10)
    {
        $buffer = '<tbody>';

        if (!static::$highlightSet) {
            ini_set('highlight.default', '"class="default');
            ini_set('highlight.keyword', '"class="keyword');
            ini_set('highlight.string', '"class="string');
            ini_set('highlight.html', '"class="html');
            ini_set('highlight.comment', '"class="comment');
            static::$highlightSet = true;
        }

        if (file_exists($path)) {
            $aw_source = highlight_file($path, true);
            $aw_source = str_replace('<code>', '', $aw_source);
            $aw_source = str_replace(array("\r\n", "\r", "\n"), '', $aw_source);
            $aw_source = trim($aw_source);
            $aw_source = str_replace('style="color: "', '', $aw_source);
            $aw_source = str_replace('<br /></span>', '</span><br />', $aw_source);
            $aw_lines = explode("<br />", $aw_source);

            $i = 1;

            foreach ($aw_lines as $aw_line) {
                $line_disp = '<tr class="codeLine"><td><div align="right"><a name="[numlink]"></a><a href="#[numlink]">[num]</a></div><td>';
                $line_disp = str_replace("[numlink]", substr(md5($path), 0, 5) . sprintf("%03d", $i), $line_disp);
                $line_disp = str_replace("[num]", sprintf("%03d", $i), $line_disp);
                if ($highlight == $i && $highlight !== 0) {
                    $line_disp = str_replace('<tr class="codeLine">', '<tr class="codeLine danger">', $line_disp);
                }
                $line_disp .= $aw_line;

                if ($showAll === false) {
                    if ($highlight !== 0 && $i >= ($highlight - $linesBeforeAndAfter) && ($i <= $highlight + $linesBeforeAndAfter)) {
                        $buffer .= $line_disp . "</td></tr>";
                    }
                } else {
                    $buffer .= $line_disp . "</td></tr>";
                }

                $i++;
            }


        }
        $buffer .= "</tbody>";
        echo $buffer;
    }
}