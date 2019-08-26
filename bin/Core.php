<?php

namespace VKAPI;

/**
 * Базовый класс для работы с VK API
 */
class VK
{
    /**
     * Список официальных приложений для прямой авторизации
     */
    static $authServers = [
        ['2274003', 'hHbZxrka2uZ6jB1inYsH'],
        ['3140623', 'VeWdmVclDCtn6ihuP1nt'],
        ['3682744', 'mY6CDUswIVdJLCD3j15n'],
        ['3697615', 'AlVXZFMUqyrnABp8ncuU'],
        ['3502557', 'PEObAuQi6KloPM4T30DV']
    ];

    static $api_version = '5.101'; // Версия VK API

    public $token; // Токен доступа

    /**
     * Прямая авторизация
     * 
     * @param string $login                 - логин пользователя
     * @param string $password              - пароль
     * [@param callable $validation = null] - функция обработки 2ФА 
     * [@param string $scope = '...']       - разрешения доступа
     * [@param int $dfacode = null]         - ключ дфуфакторовой аутентификации
     * 
     * @return VK - возвращает сам себя
     * 
     * @throws \Exception - выбрасывает исключение при ошибке авторизации
     */
    public function auth (string $login, string $password, callable $validation = null, string $scope = 'notify,friends,photos,audio,video,stories,pages,status,notes,messages,wall,offline,docs,groups,email', int $dfacode = null): VK
    {
        $authServer = rand (0, sizeof (self::$authServers) - 1);

        $data = json_decode (@file_get_contents ('https://api.vk.com/oauth/token?grant_type=password&client_id='. self::$authServers[$authServer][0] .'&scope='. $scope .'&client_secret='. self::$authServers[$authServer][1] .'&username='. urlencode ($login) .'&password='. urlencode ($password) .'&2fa_supported=1'. ($dfacode !== null ? '&code='. $dfacode : ''), false, stream_context_create ([
            'http' => [
                'ignore_errors' => true
            ]
        ])), true);

        if (!isset ($data['access_token']))
        {
            if (isset ($data['error']) && $data['error'] == 'need_validation' && $validation !== null)
                return $this->auth ($login, $password, $validation, $scope, $validation ($data));

            throw new \Exception ('Auth error. Data: '. PHP_EOL . PHP_EOL . print_r ($data, true));
        }
        
        $this->token = $data['access_token'];

        return $this;
    }

    /**
     * Получение объекта метода для упрощения запросов к API
     * 
     * @param string $name - префикс метода
     * 
     * @return Method - возвращает объект метода
     * 
     * @example
     * 
     * $API->users->get ([
     *    'user_ids' => 1
     * ]);
     */
    public function __get (string $name): Method
    {
        return new Method ($this, $name);
    }

    /**
     * Прямой запрос к VK API
     * 
     * @param string $method - метод API
     * @param array $params  - параметры запроса
     * 
     * @return array|null - возвращает результат запроса 
     */
    public function request (string $method, array $params): ?array
    {
        return json_decode (@file_get_contents ('https://api.vk.com/method/'. $method .'?'. http_build_query ($params) .'&access_token='. $this->token .'&v='. self::$api_version), true);
    }
}
