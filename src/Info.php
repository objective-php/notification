<?php

namespace ObjectivePHP\Notification;

/**
 * Class Info
 * @package ObjectivePHP\Notification
 */
class Info extends AbstractMessage
{
    protected $type = 'info';

    protected $isError = false;
}