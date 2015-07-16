<?php

namespace RandomQuoteBot\RandomQuote;

use DOMDocument;
use DOMNode;
use RandomQuoteBot\AbstractRandomQuote;

class GermanBashRandomQuote extends AbstractRandomQuote
{
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

            return $this->formatQuote($randQuote);
        }

        throw new \Exception('Was not able to find a quote on german bash');
    }

    /**
     * @param $quotes
     *
     * @return mixed
     */
    protected function getRandomEntry($quotes)
    {
        $quoteNumber = mt_rand(0, $quotes->length);
        $randQuote = $quotes->item($quoteNumber);
        return $randQuote;
    }

    /**
     * @param $randQuote
     *
     * @return string
     */
    protected function formatQuote($randQuote)
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
 