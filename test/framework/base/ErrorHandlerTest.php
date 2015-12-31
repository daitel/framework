<?php
/**
 * @link https://github.com/daitel/framework
 */

use df\base\ErrorHandler;

/**
 * Daitel Framework
 * Test Class for Error Handler work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class ErrorHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @depends DfAppTest::testSetupEx
     */
    public function testShowSources()
    {
        $path = DfApp::getRuntimePath(true) . 'app/controllers/MainController.php';
        $this->checkSources($this->sources($path, true));
        $this->checkSources($this->sources($path, false, 20));
        $this->checkSources($this->sources($path, false, 20, 5));

        $pathNotExist = DfApp::getRuntimePath(true) . 'app/controllers/MainController.php1';
        $this->assertTrue($this->sources($pathNotExist) == "<tbody><td><tr>File not exist</tr></td></tbody>");
    }

    private function checkSources($data)
    {
        $this->assertTrue(
            !empty($data)
        );

        $elements = [
            'tr',
            'td',
            'div',
            'tbody'
        ];

        foreach ($elements as $element) {
            $this->assertTrue(is_numeric(strpos($data, $element)));
        }
    }

    private function sources($path, $showAll = false, $highlight = 0, $linesBeforeAndAfter = 10)
    {
        ob_start();
        ErrorHandler::showSources($path, $showAll, $highlight, $linesBeforeAndAfter);
        $data = ob_get_contents();
        ob_end_clean();

        return $data;
    }
}