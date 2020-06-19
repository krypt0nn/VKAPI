<?php

namespace VKAPI;

/**
 * Интерфейс дял работы с Callback API
 */
class Callback
{
    public VK $API; // Объект VK API

    protected ?string $secret = null; // Секретный ключ сервера (null чтобы не сверять)
    protected string $confirmation; // Строка, которую необходимо вернуть для подтвержденяи сервера
    protected int $selfId; // ID группы

    protected array $events = []; // Список событий

    /**
     * Конструктор
     * 
     * @param string|VK $API - токен или экземпляр объекта VK API
     * @param string $confirmation - строка подтверждения сервера
     * 
     * [@param string $secret = null] - секретный ключ подтверждения запросов к API
     * Если $secret указан как null (по умолчанию) - проверки запросов не будет
     * Если $secret указан - будут игнорироваться все запросы без поля secret, а так же те, у которых secret отличается от указанного
     * 
     * @example
     * 
     * $vk = new VK ('токен');
     * $callback = new Callback ($vk, 'строка подтверждения сервера');
     * 
     * $callback->on ('message_new', function ($params) use ($vk)
     * {
     *     $vk->messages->send ([
     *         'message' => 'Привет, ты сказал "'. $params['message']['text'] .'"',
     *         'peer_id' => $params['message']['from_id']
     *     ]);
     * });
     * 
     * $callback->process ();
     * 
     */
    public function __construct ($API, string $confirmation, string $secret = null)
    {
        # Превращаем токен в объект VK API
        if (is_string ($API))
            $API = new VK ($API);
        
        # Сверяем, а то ли нам вообще подсунули?
        if (!is_a ($API, 'VKAPI\\VK'))
            throw new \Exception ('$API must be instance of VKAPI\\VK or group access token');

        # Проверяем токен на валидность
        $group_id = $API->groups->getById ()['response'][0]['id'] ?? null;

        if ($group_id === null)
            throw new \Exception ('Incorrect VK API token');

        $this->API    = $API;
        $this->secret = $secret;
        $this->selfId = $group_id;

        $this->confirmation = $confirmation;

        # Задаём стандартное событие обработки confirmation
        $this->events['confirmation'] = function ()
        {
            echo $this->confirmation;
        };
    }

    /**
     * Задание событий callback API
     * 
     * @param string $action - строка-идентификатор события (@link https://vk.com/dev/groups_events)
     * @param callable $callback - коллбэк обработки события
     * 
     * @return Callback
     */
    public function on (string $action, callable $callback): Callback
    {
        $this->events[$action] = $callback;

        return $this;
    }

    /**
     * Обработка запроса callback API
     * 
     * [@param array $params = null] - массив параметров запроса
     * По умолчанию автоматически получит их из потока php://input
     * 
     * [@param bool $silent = false] - вывод статуса обработки запроса
     * При значении false (по умолчанию) выведет в поток вывода значение "ok"
     * При значении true, соответственно, ничего не выведет
     */
    public function process (array $params = null, bool $silent = false)
    {
        # Получаем параметры запроса
        $params ??= json_decode (file_get_contents ('php://input'), true);

        # Проверяем их на валидность
        if ($params['group_id'] != $this->selfId)
            return null;

        if ($this->secret !== null && (!isset ($params['secret']) || $params['secret'] != $this->secret))
            return null;

        # Обрабатываем событие callback API
        $return = isset ($this->events[$params['type']]) ?
            $this->events[$params['type']] ($params['object']) : null;

        # Если надо - выводим ответ "ok"
        if (!$silent)
            echo 'ok';

        return $return;
    }

    /**
     * Буферизация обработки запроса callback API
     * 
     * Выполняет метод process с переданными параметрами и буферезиует весь поток
     * вывода, генерируемый этим методом. По окончанию работы метода
     * возвращает пользователю строку с содержимым буферизованного потока вывода
     * 
     * @return string
     */
    public function processFlush (array ...$params): string
    {
        ob_start ();

        $this->process (...$params);

        return ob_get_flush ();
    }
}
