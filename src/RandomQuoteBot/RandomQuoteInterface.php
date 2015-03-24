<?php
namespace RandomQuoteBot;

interface RandomQuoteInterface
{
    /**
     * @param $channel
     */
    public function sendQuote($channel);
}
