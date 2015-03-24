<?php
namespace RandomQuoteBot;

use RandomQuoteBot\Library\Slack\SlackBot;
use RandomQuoteBot\Library\Slack\SlackConfig;
use RandomQuoteBot\RandomQuote\AxelStollRandomQuote;

class RandomQuoteFactory
{
    const CONCRETE_CLASSES_NAMESPACE = '\\RandomQuoteBot\\RandomQuote\\';
    const CONCRETE_CLASSES_APPENDIX = 'RandomQuote';

    /**
     * @param $name
     * @param SlackConfig $slackConfig
     * @return RandomQuoteInterface
     * @throws \Exception
     */
    public static function createRandomQuoteByName($name, SlackConfig $slackConfig)
    {
        $filter = new \Zend\Filter\Word\DashToCamelCase();
        $className = self::CONCRETE_CLASSES_NAMESPACE . $filter->filter($name) . 'RandomQuote';
        
        if (!class_exists($className)) {
            throw new \Exception('Missing RandomQuote Class: ' . $className);
        }
        
        return new $className(self::createSlackBot($slackConfig));
    }

    /**
     * @param SlackConfig $slackConfig
     * @return SlackBot
     */
    private static function createSlackBot(SlackConfig $slackConfig)
    {
        return new SlackBot($slackConfig);
    }
    
    /**
     * @param SlackConfig $slackConfig
     * @return AxelStollRandomQuote
     */
    public static function createAxelStollRandomQuote(SlackConfig $slackConfig)
    {
        return new AxelStollRandomQuote(self::createSlackBot($slackConfig));
    }
}
