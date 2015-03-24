<?php
namespace RandomQuoteBot;

use RandomQuoteBot\Library\Slack\SlackBot;

abstract class AbstractRandomQuote implements RandomQuoteInterface
{
    /**
     * @var SlackBot
     */
    protected $slackBot;

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
     * @param string $channel
     * @return \Frlnc\Slack\Contracts\Http\Response
     */
    public function sendQuote($channel)
    {
        return $this->slackBot->postMessage($channel, $this->getRandomQuote());
    }
}
