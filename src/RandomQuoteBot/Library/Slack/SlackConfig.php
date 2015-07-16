<?php
namespace RandomQuoteBot\Library\Slack;

use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class SlackConfig
{
    const KEY_ROOT = 'slack';
    const KEY_API_KEY = 'api_key';
    const KEY_CHANNELS = 'channels';
    const KEY_USERS = 'users';
    const KEY_USER_ID = 'id';
    const KEY_USER_NAME = 'name';
    const KEY_USER_IMAGE = 'image';
    const KEY_PROVIDERS = 'providers';

    /**
     * @var
     */
    private $options;

    /**
     * @param $fileName
     */
    public function __construct($fileName)
    {
        $config = self::parseYml($fileName);
        if (!isset($config[self::KEY_ROOT])) {
            throw new ParseException('Missing root key: ' . self::KEY_ROOT);
        }
        $this->options = $config[self::KEY_ROOT];
    }

    /**
     * @return null|string
     */
    public function getApiKey()
    {
        return isset($this->options[self::KEY_API_KEY]) ? $this->options[self::KEY_API_KEY] : null;
    }
    
    /**
     * @return array
     */
    public function getUsers()
    {
        return isset($this->options[self::KEY_USERS]) ? $this->options[self::KEY_USERS] : [];
    }

    /**
     * @param $name
     * @return null|array
     */
    public function getUserByName($name)
    {
        foreach ($this->options[self::KEY_USERS] as $user) {
            if ($user[self::KEY_USER_NAME] == $name) return $user;
        }
        
        return null;
    }

    /**
     * @param $id
     * @return null|array
     */
    public function getUserById($id)
    {
        foreach ($this->options[self::KEY_USERS] as $user) {
            if ($user[self::KEY_USER_ID] == $id) return $user;
        }

        return null;
    }
    
    /**
     * @return array
     */
    public function getChannel()
    {
        return isset($this->options[self::KEY_CHANNELS]) ? $this->options[self::KEY_CHANNELS] : [];
    }

    public function getQuoteProviders()
    {
        if (!isset($this->options[self::KEY_PROVIDERS])) {
            return [];
        }

        return $this->options[self::KEY_PROVIDERS];
    }

    /**
     * @param $fileName
     * @return mixed
     */
    protected static function parseYml($fileName)
    {
        if (!file_exists($fileName)) {
            throw new \Exception($fileName);
        }

        return Yaml::parse($fileName);
    }
}
