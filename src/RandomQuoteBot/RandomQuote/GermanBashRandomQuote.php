<?php

namespace RandomQuoteBot\RandomQuote;

use DOMDocument;
use DOMNode;
use RandomQuoteBot\AbstractRandomQuote;

class GermanBashRandomQuote extends AbstractRandomQuote
{
    /**
     * @var array
     */
    protected static $invalidContents = [
        'GA_googleFillSlot("gbo_quotes_728x90_1");',
        'GA_googleFillSlot("gbo_quotes_728x90_2");',
    ];

    /**
     * @return string
     */
    protected function getBotName()
    {
        return 'German Bash';
    }

    /**
     * @return string
     */
    protected function getBotAvatarUrl()
    {
        return 'http://german-bash.org/apple-touch-icon.png';
    }

    /**
     * @throws \Exception
     * @return string
     */
    protected function getRandomQuote()
    {
        $content = file_get_contents('http://german-bash.org/action/random');
        //the german bash site has malformed html -.-
        libxml_use_internal_errors(true);
        $document = new DOMDocument();
        $document->loadHtml($content);

        $xpath = new \DOMXPath($document);

        $quotes = $xpath->query('//div[@class="zitat"]');

        for ($i = 0; $i < 10; $i++) {
            $randQuote = $this->getRandomEntry($quotes);

            if (!$randQuote->hasChildNodes()) {
                continue;
            }

            $quoteString = $this->formatQuote($randQuote);
            if (in_array($quoteString, self::$invalidContents)) {
                continue;
            }

            return $quoteString;
        }

        throw new \Exception('Was not able to find a quote on german bash');
    }

    /**
     * @param \DOMNodeList $quotes
     *
     * @return DOMNode
     */
    protected function getRandomEntry(\DOMNodeList $quotes)
    {
        $quoteNumber = mt_rand(0, $quotes->length);
        $randQuote = $quotes->item($quoteNumber);
        return $randQuote;
    }

    /**
     * @param DOMNode $randQuote
     *
     * @return string
     */
    protected function formatQuote(DOMNode $randQuote)
    {
        $lines = [];

        /** @var DOMNode $childNode */
        foreach ($randQuote->childNodes as $childNode) {
            $line = trim($childNode->textContent);

            if (empty($line)) {
                continue;
            }

            $line = preg_replace('/</', '*<', $line);
            $line = preg_replace('/>/', '>*', $line);

            $lines[] = $line;
        }

        return join(" \n", $lines);
    }
}
