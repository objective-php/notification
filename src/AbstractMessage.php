<?php

namespace ObjectivePHP\Notification;

use ObjectivePHP\Primitives\Collection\Collection;
use ObjectivePHP\Primitives\String\Str;

/**
 * Class AbstractMessage
 * @package ObjectivePHP\Notification
 */
class AbstractMessage implements MessageInterface
{

    /** @var string type */
    protected $type;

    /** @var Collection $message */
    protected $message;

    /** @var  bool $isError */
    protected $isError;

    /**
     * AbstractMessage constructor.
     * @param $message
     */
    public function __construct($message)
    {
        $this->message = Str::cast($message);
    }

    /**
     * Get the type of the Message.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * It let you know if the Message is an error.
     *
     * @return bool
     */
    public function isError(): bool
    {
        return $this->isError;
    }

    /**
     * Turn the Message to an error.
     *
     * @param bool $isError
     * @return $this
     */
    public function setError(bool $isError)
    {
        $this->isError = $isError;
        return $this;
    }

    /**
     * Get the string representation of the Message.
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->message;
    }
}