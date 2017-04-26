<?php

namespace ObjectivePHP\Notification;

/**
 * Class Success
 * @package ObjectivePHP\Notification
 */
class Success extends AbstractMessage
{
    protected $type = 'success';

    protected $isError = false;
}