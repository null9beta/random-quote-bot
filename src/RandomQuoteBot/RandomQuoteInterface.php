<?php
namespace RandomQuoteBot;

interface RandomQuoteInterface
{
    /**
     * @param string $channel
     * @return \Frlnc\Slack\Contracts\Http\Response
     */
    public function sendQuote($channel);
}
