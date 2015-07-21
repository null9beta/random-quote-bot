<?php

namespace RandomQuoteBot\RandomQuote;

use DOMDocument;
use DOMNode;
use DOMNodeList;
use RandomQuoteBot\AbstractRandomQuote;

class IbashRandomQuote extends AbstractRandomQuote
{
    /**
     * @throws \Exception
     * @return string
     */
    protected function getRandomQuote()
    {
        $content = file_get_contents('http://www.ibash.de/random.html');
        libxml_use_internal_errors(true);
        $document = new DOMDocument();
        $document->loadHtml($content);

        $xpath = new \DOMXPath($document);

        $quotes = $xpath->query('//td[@class="quote"]');
        $randQuote = $this->getRandomEntry($quotes);

        return $this->formatQuote($randQuote, $xpath);
    }

    /**
     * @param DOMNodeList $quotes
     *
     * @return mixed
     */
    protected function getRandomEntry(DOMNodeList $quotes)
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
        $line = trim($randQuote->textContent);
        $line = preg_replace('/</', "\n *<", $line);
        $line = preg_replace('/>/', '>*', $line);
        $line = preg_replace('/(\d+?) Kommentare/', '', $line);

        return $line;
    }
}
