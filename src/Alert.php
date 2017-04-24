<?php

namespace ObjectivePHP\Notification;

/**
 * Class Alert
 * @package ObjectivePHP\Notification
 */
class Alert extends AbstractMessage
{
    protected $type = 'danger';

    protected $isError = true;
}