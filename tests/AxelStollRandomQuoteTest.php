<?php

namespace RandomQuoteBot\Tests;

use RandomQuoteBot\RandomQuote\AxelStollRandomQuote;

class AxelStollRandomQuoteTest extends \PHPUnit_Framework_TestCase
{

    public function testGetQuote()
    {
        $slackBot = $this->getMockBuilder('RandomQuoteBot\Library\Slack\SlackBot')
            ->disableOriginalConstructor()
            ->getMock();
        $slackBot->expects($this->any())
            ->method('postMessage')
            ->will($this->returnArgument(1));
        $randomQuote = new AxelStollRandomQuote($slackBot);

        $quote = ($randomQuote->sendQuote('test'));

        $this->assertTrue(strlen($quote) > 1);
    }
}
