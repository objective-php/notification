<?php
namespace Tests\ObjectivePHP\Notification;;

use ObjectivePHP\Notification;
use ObjectivePHP\PHPUnit\TestCase;


class MessageTest extends TestCase
{

    public function testToString()
    {
        $message = new Notification\Info('test');
        $this->assertEquals('test', $message);
    }

    public function testAddMessage()
    {
        $message = new Notification\Info('hello');
        $messageStack = new Notification\Stack();

        $messageStack->addMessage('data.form', $message);

        $this->assertEquals(['data.form' => $message], $messageStack->toArray());
    }

    public function testMessagesFiltering()
    {

        $notifications = new Notification\Stack();
        $message      = new Notification\Info('hello');

        $notifications->addMessage('x.y', $message);
        $notifications->addMessage('x.z', $message);

    }

    public function testMessageIsError()
    {
        $this->assertTrue((new Notification\Alert('By default an alert message is an error.'))->isError());
        $this->assertTrue((new Notification\Warning('By default a warning message is an error.'))->isError());
        $this->assertFalse((new Notification\Info('By default an info message isn\'t an error.'))->isError());
        $this->assertFalse((new Notification\Success('By default a success message isn\'t an error.'))->isError());

        $this->assertFalse((new Notification\Alert('The error behavior can be override.'))->setError(false)->isError());
    }
}
