# random-quote-bot
Random Quote Bot for Slack

Simple usage of the Slack API to post a random quote to a specific channel.
Feel free to fork and add own RandomQuote classes.

## Adding new Quotes
 - Create a new Concret Quote here -> RandomQuoteBot\RandomQuote
 - Create a Command that will use the new Quote

## Usage
```
bin/console quote:send-random-quote-to-slack <configName> <channelName>
```
