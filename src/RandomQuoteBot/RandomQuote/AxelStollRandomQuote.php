<?php
namespace RandomQuoteBot\RandomQuote;

use RandomQuoteBot\AbstractRandomQuote;

class AxelStollRandomQuote extends AbstractRandomQuote
{
    /**
     * @return string
     */
    protected function getBotName()
    {
        return 'Axel Stoll';
    }

    /**
     * @return string
     */
    protected function getBotAvatarUrl()
    {
        return 'http://www.lokaltermin.eu/images/stoll.jpg';
    }

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

}
