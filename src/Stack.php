<?php

namespace ObjectivePHP\Notification;

use ObjectivePHP\Matcher\Matcher;
use ObjectivePHP\Primitives\Collection\Collection;

/**
 * Class Stack
 * @package ObjectivePHP\Notification
 */
class Stack extends Collection implements MessageInterface
{

    /** @var Matcher $matcher */
    protected $matcher;

    /**
     * Stack constructor.
     *
     * @param array $messages
     */
    public function __construct($messages = [])
    {
        parent::__construct($messages);

        $this->restrictTo(MessageInterface::class);
    }

    /**
     * Reduce the Stack with a filter.
     **
     * @param $filter
     *
     * @return Stack
     * @throws \ObjectivePHP\Primitives\Exception
     */
    public function for($filter)
    {
        return (clone $this)->filter(function($value, $key) use($filter) {
            return $this->getMatcher()->match($filter, $key);
        });
    }

    /**
     * Add a Message to the Stack.
     *
     * @param string           $key
     * @param MessageInterface $message
     *
     * @return $this
     * @throws \ObjectivePHP\Primitives\Exception
     */
    public function addMessage($key, MessageInterface $message)
    {
        $this->set($key, $message);

        return $this;
    }

    /**
     * @param string|null $type
     *
     * @return int
     * @throws \ObjectivePHP\Primitives\Exception
     */
    public function count($type = null)
    {
        if(is_null($type))
        {
            $count = parent::count();
        }
        else
        {
            $count = 0;
            $this->each(
                function (MessageInterface $message) use (&$count, $type)
                {
                    if ($message instanceof Stack) $count += $message->count($type);
                    elseif ($type == $message->getType()) $count ++;
                }
            );
        }

        return $count;
    }

    public function hasError()
    {
        foreach ($this->getInternalValue() as $message) {
            if ($message->isError()) {
                return true;
            }
        }
        return false;
    }

    public function isError(): bool
    {
        return $this->hasError();
    }


    /**
     * @return Matcher
     */
    public function getMatcher()
    {
        if(is_null($this->matcher))
        {
            $this->matcher = new Matcher();
        }

        return $this->matcher;
    }

    /**
     * @param Matcher $matcher
     *
     * @return $this
     */
    public function setMatcher(Matcher $matcher)
    {
        $this->matcher = $matcher;
        return $this;
    }
}