<?php
namespace RandomQuoteBot;

use RandomQuoteBot\Library\Slack\SlackBot;

abstract class AbstractRandomQuote
{
    /**
     * @var SlackBot
     */
    private $slackBot;

    /**
     * @param SlackBot $slackBot
     */
    public function __construct(SlackBot $slackBot)
    {
        $this->slackBot = $slackBot;
    }

    /**
     * @return string
     */
    abstract protected function getRandomQuote();

    /**
     * @param $channel
     */
    public function sendQuote($channel)
    {
        $this->slackBot->postMessage($channel, $this->getRandomQuote());
    }
}
