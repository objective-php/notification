<?php

namespace ObjectivePHP\Notification;

/**
 * Interface MessageInterface
 * @package ObjectivePHP\Notification
 */
interface MessageInterface
{
    /**
     * MessageInterface constructor.
     * @param $message
     */
    public function __construct($message);

    /**
     * Get the type of the Message.
     *
     * @return string
     */
    public function getType();

    /**
     * It let you know if the Message is an error.
     *
     * @return bool
     */
    public function isError() : bool;
}
