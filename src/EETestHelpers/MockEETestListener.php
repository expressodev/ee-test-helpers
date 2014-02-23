<?php

namespace EETestHelpers;

use Mockery;

/**
 * Mock EE Test Listener
 *
 * Runs tests with a mocked global EE instance. All standard EE libraries have
 * been replaced by test doubles using Mockery, which by default will raise an exception
 * if unexpected methods are called on them.
 *
 * You can set expectations on the mocked object like this:
 *
 * ee()->security->shouldReceive('secure_forms_check');
 */
class MockEETestListener implements \PHPUnit_Framework_TestListener
{
    private static $ee;

    public static function getMockEEInstance()
    {
        return static::$ee;
    }

    public static function setMockEEInstance($ee)
    {
        static::$ee = $ee;
    }

    public function addError(\PHPUnit_Framework_Test $test, \Exception $e, $time) {}

    public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time) {}

    public function addIncompleteTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) {}

    public function addSkippedTest(\PHPUnit_Framework_Test $test, \Exception $e, $time) {}

    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite) {}

    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite) {}

    public function startTest(\PHPUnit_Framework_Test $test) 
    {
        // create a fresh mocked EE instance
        static::setMockEEInstance($this->createMockEEInstance());
    }

    public function endTest(\PHPUnit_Framework_Test $test, $time)
    {
        // clear the mock EE instance
        static::setMockEEInstance(null);
    }

    public function createMockEEInstance()
    {
        // mock global EE instance
        $ee = Mockery::mock('ee_instance');

        // mock common EE libraries
        $ee->cache = Mockery::mock('ee_cache');
        $ee->config = Mockery::mock('ee_config');
        $ee->cp = Mockery::mock('ee_cp');
        $ee->db = Mockery::mock('ee_db');
        $ee->email = Mockery::mock('ee_email');
        $ee->extensions = Mockery::mock('ee_extensions', array('active_hook' => false));
        $ee->extensions->last_call = false;
        $ee->functions = Mockery::mock('ee_functions');
        $ee->input = Mockery::mock('ee_input');
        $ee->lang = Mockery::mock('ee_lang', array('loadfile' => null));
        $ee->lang->language = array();
        $ee->load = Mockery::mock('ee_load', array('helper' => null, 'library' => null, 'model' => null));
        $ee->localize = Mockery::mock('ee_localize');
        $ee->output = Mockery::mock('ee_output');
        $ee->security = Mockery::mock('ee_security');
        $ee->session = Mockery::mock('ee_session');
        $ee->TMPL = Mockery::mock('ee_tmpl');

        return $ee;
    }
}
