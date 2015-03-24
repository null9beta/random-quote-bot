<?php
namespace RandomQuoteBot\RandomQuote;

use RandomQuoteBot\AbstractRandomQuote;

class AxelStollRandomQuote extends AbstractRandomQuote
{
    /**
     * @return string
     */
    protected function getRandomQuote()
    {
        $content = file_get_contents('http://www.lokaltermin.eu/stoll-zitate');
        preg_match_all('/<li>([^<].*)<\/li>/i',$content, $result);

        $randPos = mt_rand(0, count($result[1]));
        return $result[1][$randPos];
    }


    /**
     * @param string $channel
     * @return \Frlnc\Slack\Contracts\Http\Response
     */
    public function sendQuote($channel)
    {
        return $this->slackBot->postMessage(
            $channel,
            $this->getRandomQuote(),
            'Axel Stoll',
            'http://www.lokaltermin.eu/images/stoll.jpg'
        );
    }

}
