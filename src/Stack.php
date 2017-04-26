<?php

namespace ObjectivePHP\Notification;

use ObjectivePHP\Matcher\Matcher;
use ObjectivePHP\Primitives\Collection\Collection;

/**
 * Class Stack
 *
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
     *
     * @param $filter
     *
     * @return Stack
     * @throws \ObjectivePHP\Primitives\Exception
     */
    public function for ($filter)
    {
        return (clone $this)->filter(function ($value, $key) use ($filter) {
            return $this->getMatcher()->match($filter, $key);
        });
    }
    
    /**
     * @return Matcher
     */
    public function getMatcher()
    {
        if (is_null($this->matcher)) {
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
        if ($this->lacks($key)) {
            $this->set($key, $message);
        } else {
            $previous = $this->get($key);
            if ($previous instanceof Stack) {
                $previous->append($message);
            } else {
                $stack = (new Stack())->append($previous, $message);
                $this->set($key, $stack);
            }
        }
        
        return $this;
    }
    
    /**
     * @param string|null $filter
     *
     * @return int
     * @throws \ObjectivePHP\Primitives\Exception
     */
    public function count($filter= null)
    {
        if (is_null($filter)) {
            $count = parent::count();
        } else {
            $count = 0;
            $this->each(
                function (MessageInterface $message) use (&$count, $filter) {
                    if ($message instanceof Stack) {
                        $count += $message->count($filter);
                    } elseif ($this->getMatcher()->match($filter, $message->getType())) {
                        $count++;
                    }
                }
            );
        }
        
        return $count;
    }
    
    /**
     * @return bool
     */
    public function isError(): bool
    {
        return $this->hasError();
    }
    
    /**
     * Does the stack contain error (at whatever recursion level)?
     *
     * @return bool
     */
    public function hasError()
    {
        /** @var MessageInterface $message */
        foreach ($this->getInternalValue() as $message) {
            if ($message->isError()) {
                return true;
            }
        }
        
        return false;
    }
    
}
