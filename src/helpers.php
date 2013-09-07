<?php

/**
 * Support accessing mocked global instance using get_instance() method
 */
function get_instance()
{
    return EETestHelpers\MockEETestListener::getMockEEInstance();
}

/**
 * Support accessing mocked global instance using ee() method introduced in 2.6
 */
function ee()
{
    return EETestHelpers\MockEETestListener::getMockEEInstance();
}
