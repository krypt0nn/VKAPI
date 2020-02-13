<?php

namespace VKAPI;

/**
 * Базовый класс для работы с VK API
 */
class VK
{
    public string $token; // Токен доступа

    public function __construct (string $token = null, string $password = null, callable $validation = null, string $appId = null, string $appSecret = null, string $scope = DEFAULT_SCOPE)
    {
        if ($token !== null)
            if ($password === null)
                $this->token = $token;
                
            elseif ($appId === null)
                $this->auth ($token, $password, $validation, $scope);
            
            elseif ($appSecret !== null)
                $this->authBy ($appId, $appSecret, $token, $password, $validation, $scope);

            else throw new \Exception ('You must enter app secret');
    }

    /**
     * Прямая авторизация (через готовые приложения)
     * 
     * @param string $login                 - логин пользователя
     * @param string $password              - пароль
     * [@param callable $validation = null] - функция обработки 2ФА 
     * [@param string $scope = '...']       - разрешения доступа
     * [@param int $dfacode = null]         - ключ дфуфакторной аутентификации
     * 
     * @return VK - возвращает сам себя
     * 
     * @throws \Exception - выбрасывает исключение при ошибке авторизации
     */
    public function auth (string $login, string $password, callable $validation = null, string $scope = DEFAULT_SCOPE, int $dfacode = null): VK
    {
        $authServer = rand (0, sizeof (AUTH_SERVERS) - 1);

        $data = json_decode (@file_get_contents ('https://api.vk.com/oauth/token?grant_type=password&client_id='. AUTH_SERVERS[$authServer][0] .'&scope='. $scope .'&client_secret='. AUTH_SERVERS[$authServer][1] .'&username='. urlencode ($login) .'&password='. urlencode ($password) .'&2fa_supported=1'. ($dfacode !== null ? '&code='. $dfacode : ''), false, stream_context_create ([
            'http' => [
                'ignore_errors' => true
            ]
        ])), true);

        if (!isset ($data['access_token']))
        {
            if (isset ($data['error']) && $data['error'] == 'need_validation' && $validation !== null)
                return $this->authBy (AUTH_SERVERS[$authServer][0], AUTH_SERVERS[$authServer][1], $login, $password, $validation, $scope, $validation ($data));

            throw new \Exception ('Auth error. Data: '. PHP_EOL . PHP_EOL . print_r ($data, true));
        }
        
        $this->token = $data['access_token'];

        return $this;
    }

    /**
     * Прямая авторизация (через собственное приложение)
     * 
     * @param string $appId                 - ID приложения ВК
     * @param string $appSecret             - секретный ключ приложения
     * @param string $login                 - логин пользователя
     * @param string $password              - пароль
     * [@param callable $validation = null] - функция обработки 2ФА 
     * [@param string $scope = '...']       - разрешения доступа
     * [@param int $dfacode = null]         - ключ дфуфакторной аутентификации
     * 
     * @return VK - возвращает сам себя
     * 
     * @throws \Exception - выбрасывает исключение при ошибке авторизации
     */
    public function authBy (string $appId, string $appSecret, string $login, string $password, callable $validation = null, string $scope = DEFAULT_SCOPE, int $dfacode = null): VK
    {
        $data = json_decode (@file_get_contents ('https://api.vk.com/oauth/token?grant_type=password&client_id='. $appId .'&scope='. $scope .'&client_secret='. $appSecret .'&username='. urlencode ($login) .'&password='. urlencode ($password) .'&2fa_supported=1'. ($dfacode !== null ? '&code='. $dfacode : ''), false, stream_context_create ([
            'http' => [
                'ignore_errors' => true
            ]
        ])), true);

        if (!isset ($data['access_token']))
        {
            if (isset ($data['error']) && $data['error'] == 'need_validation' && $validation !== null)
                return $this->authBy ($appId, $appSecret, $login, $password, $validation, $scope, $validation ($data));

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
        return json_decode (@file_get_contents ('https://api.vk.com/method/'. $method .'?'. http_build_query ($params) .'&access_token='. $this->token .'&v='. API_VERSION), true);
    }
}
