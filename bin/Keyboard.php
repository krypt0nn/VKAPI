<?php

namespace VKAPI;

/**
 * Класс клавиатуры
 * 
 * Предоставляет функционал для отправки сообщений от имени сообщества, включающих клавиатуру
 * @link https://vk.com/dev/bots_docs_3?f=4.%2BКлавиатуры%2Bдля%2Bботов
 * 
 * @example
 * 
 * use VKAPI\Buttons\Text;
 * 
 * $keyboard = new Keyboard (new VK ('...')); // токен доступа сообщества
 * 
 * $keyboard->buttons->add (0, new Text ('Hello, World!'));
 * 
 * $keyboard->send ('...', 'Hello, World!'); // peer id получателя
 */
class Keyboard
{
    public VK $API; // Объект VK API
    public Buttons $buttons; // Объект кнопок клавиатуры
    public bool $inline; // Способ отображения клавиатуры

    /**
     * Конструктор клавиатуры
     * 
     * @param VK $API - объект VK API
     * [@param bool $Inline = false] - отображать ли клавиатуру внутри сообщения
     * [@param Buttons $buttons = null] - объект кнопок клавиатуры
     */
    public function __construct (VK $API, bool $inline = false, Buttons $buttons = null)
    {
        $this->API     = $API;
        $this->inline  = $inline;
        $this->buttons = $buttons ?: new Buttons;
    }

    /**
     * Отправка сообщения с клавиатурой
     * 
     * @param int $peerID             - peer ID получателя
     * @param string $message         - сообщение
     * [@param array $params = []]    - массив дополнительных параметров метода messages.send
     * [@param bool $oneTime = false] - вывести ли клавиатуру всего 1 раз
     * 
     * @return array - возвращает ответ метода
     */
    public function send (int $peerID, string $message, array $params = [], bool $oneTime = false): array
    {
        return $this->API->messages->send (array_merge ([
            'peer_id'   => $peerID,
            'message'   => $message,
            'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
            'keyboard'  => $this->toJson ($oneTime)
        ], $params));
    }

    /**
     * Очистка кнопок клавиатуры
     * 
     * @return Keyboard - возвращает сам себя
     */
    public function clear (): Keyboard
    {
        $this->buttons = new Buttons;

        return $this;
    }

    /**
     * Получение массива клавиатуры
     * 
     * [@param bool $oneTime = false] - вывести ли клавиатуру всего 1 раз
     * 
     * @return array - возвращает массив клавиатуры
     */
    public function toArray (bool $oneTime = false): array
    {
        return $this->inline ? [
            'buttons'  => $this->buttons->toArray (),
            'inline'   => true
        ] : [
            'one_time' => $oneTime,
            'buttons'  => $this->buttons->toArray ()
        ];
    }

    /**
     * Получение JSON массива клавиатуры
     * 
     * [@param bool $oneTime = false] - вывести ли клавиатуру всего 1 раз
     * 
     * @return string - возвращает JSON массив клавиатуры
     */
    public function toJson (bool $oneTime = false): string
    {
        return json_encode ($this->toArray ($oneTime));
    }
}
