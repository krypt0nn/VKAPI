<?php

namespace VKAPI;

/**
 * Интерфейс для работы с LongPoll API
 */
class LongPoll
{
    protected $API;
    protected $key;
    protected $server;
    protected $ts;

    // Версия LongPoll API
    static $longpoll_version = '3';
    
    /**
     * Конструктор
     * 
     * @param VK $API - объект VK API
     */
    public function __construct (VK $API)
    {
        $this->API = $API;

        $data = $this->API->messages->getLongPollServer ([
            'lp_version' => self::$longpoll_version
        ]);

        if (!isset ($data['response']))
            throw new \Exception ('Catched some error on connecting to LongPoll server. Error info:'. PHP_EOL . PHP_EOL . print_r ($data, true));

        $this->key    = $data['response']['key'];
        $this->server = $data['response']['server'];
        $this->ts     = $data['response']['ts'];
    }

    /**
     * Получение обновлений
     * 
     * [@param int $mode = 10]
     * [@param int $wait = 25]
     * 
     * @return array - возвращает массив обновлений
     */
    public function getUpdates (int $mode = 10, int $wait = 25): array
    {
        $data = json_decode (file_get_contents ('https://'. $this->server .'?act=a_check&key='. $this->key .'&ts='. $this->ts .'&wait='. $wait .'&mode='. $mode .'&version='. self::$longpoll_version), true);

        if (isset ($data['failed']))
            switch ($data['failed'])
            {
                case 2:
                case 3:
                    $data = $this->API->messages->getLongPollServer ([
                        'lp_version' => self::$longpoll_version
                    ]);

                    $this->key    = $data['response']['key'];
                    $this->server = $data['response']['server'];
                    $this->ts     = $data['response']['ts'];

                    return $this->getUpdates ($mode, $wait);
                break;

                default:
                    throw new \Exception ('Catched some error at working with LongPoll API. Error info:'. PHP_EOL . PHP_EOL . print_r ($data, true));
                break;
            }

        $this->ts = $data['ts'];

        return $data['updates'];
    }
}
