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
     * Highlight html class
     * highlight.default
     */
    const HIGHLIGHT_DEFAULT = "default";
    /**
     * Highlight html class
     * highlight.keyword
     */
    const HIGHLIGHT_KEYWORD = "keyword";
    /**
     * Highlight html class
     * highlight.string
     */
    const HIGHLIGHT_STRING = "string";
    /**
     * Highlight html class
     * highlight.html
     */
    const HIGHLIGHT_HTML = "html";
    /**
     * Highlight html class
     * highlight.comment
     */
    const HIGHLIGHT_COMMENT = "comment";
    /**
     * showSources html class
     * In table, element <tr>
     */
    const HIGHLIGHT_CODELINE = "codeLine";
    /**
     * Debug status
     * @var bool
     */
    public static $debug = false;
    /**
     * Error controller call
     * @var array
     */
    public static $errorCall = [];
    /**
     * Highlight ini setting status
     * @var bool
     */
    private static $highlightSet = false;

    /**
     * Show sources
     * This function make html code from sources
     * @param string $path
     * @param bool $showAll
     * @param int $highlight
     * @param int $linesBeforeAndAfter
     */
    public static function showSources($path, $showAll = false, $highlight = 0, $linesBeforeAndAfter = 10)
    {
        $buffer = '<tbody>';

        self::setHighlightOptions();

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
                $line_disp = '<tr class="[codeline]"><td><div align="right"><a name="[numlink]"></a><a href="#[numlink]">[num]</a></div><td>';

                $line_disp = str_replace("[codeline]", self::HIGHLIGHT_CODELINE, $line_disp);
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
        } else {
            $buffer .= "<td><tr>File not exist</tr></td>";
        }

        $buffer .= "</tbody>";
        echo $buffer;
    }

    /**
     * Set highlight ini_set variables
     */
    private static function setHighlightOptions()
    {
        if (!self::$highlightSet) {
            ini_set('highlight.default', self::setHtmlClass(self::HIGHLIGHT_DEFAULT));
            ini_set('highlight.keyword', self::setHtmlClass(self::HIGHLIGHT_KEYWORD));
            ini_set('highlight.string', self::setHtmlClass(self::HIGHLIGHT_STRING));
            ini_set('highlight.html', self::setHtmlClass(self::HIGHLIGHT_HTML));
            ini_set('highlight.comment', self::setHtmlClass(self::HIGHLIGHT_COMMENT));
            self::$highlightSet = true;
        }
    }

    /**
     * Set HTML class
     * @param string $class
     * @return string
     */
    private static function setHtmlClass($class)
    {
        return '" class="' . $class . '"';
    }

    /**
     * Register Handlers
     */
    public static function registerHandlers()
    {
        set_exception_handler("DfErrorHandler::exception");
        set_error_handler(create_function('$c, $m, $f, $l', 'throw new DfPHPException($m, $c, $f, $l);'), E_ALL);
        register_shutdown_function('DfErrorHandler::onShutdown');
    }

    /**
     * Shutdown action
     */
    public static function onShutdown()
    {
        if (($error = error_get_last()) !== null) {
            self::exception(new DfPHPException($error['message'], $error['type'], $error['file'], $error['line']));
        }
    }

    /**
     * Exception catch call
     * @param DfException $ex
     */
    public static function exception($ex)
    {
        if (self::$debug === true) {
            self::renderExceptionPage($ex);
        } else {
            self::renderErrorPage($ex);
        }
    }

    /**
     * Render Exception Page
     * @param DfException $ex
     */
    public static function renderExceptionPage($ex)
    {
        include DfApp::getRuntimePath(true) . "framework/views/errors/exception.php";
    }

    /**
     * Render Error Page
     * @param DfException $ex
     */
    private static function renderErrorPage($ex)
    {
        if (!empty(self::$errorCall)) {
            DfApp::app()->router->callByArray(self::$errorCall);
        } else {
            include DfApp::getRuntimePath(true) . "framework/views/errors/error.php";
        }
    }
}