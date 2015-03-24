<?php
namespace RandomQuoteBot\Library\Slack;

use Frlnc\Slack\Http\SlackResponseFactory;
use Frlnc\Slack\Http\CurlInteractor;
use Frlnc\Slack\Core\Commander;

class SlackBot
{
    /**
     * @var Commander
     */
    private $commander;

    /**
     * @var SlackConfig
     */
    private $slackConfig;

    /**
     * @param SlackConfig $slackConfig
     */
    public function __construct(SlackConfig $slackConfig)
    {
        $interactor = new CurlInteractor();
        $interactor->setResponseFactory(new SlackResponseFactory);
        
        $this->slackConfig = $slackConfig;
        $this->commander = new Commander($slackConfig->getApiKey(), $interactor);
    }

    public function getDirectChannel($userId)
    {
        $response = $this->commander->execute('im.open', ['user' => $userId]);
        return $response->getBody()['channel']['id'];
    }

    public function listUsers()
    {
        $response = $this->commander->execute('users.list', []);
        return $response->getBody();
    }

    public function postMessage($channel, $message, $botName = 'bot', $botImage = '')
    {
        return $this->commander->execute('chat.postMessage',
            [
                'channel' => $channel,
                'text' => $message,
                'username' => $botName,
                'icon_url' => $botImage
            ]
        );
    }

    public function postDirectMessage($userId, $message, $botName = 'bot', $botImage = '')
    {
        $directChannelId = $this->getDirectChannel($userId);
        $this->postMessage($directChannelId, $message, $botName, $botImage);
    }
}
