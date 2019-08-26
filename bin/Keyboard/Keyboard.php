<?php

namespace VKAPI;

/**
 * Класс клавиатуры
 */
class Keyboard
{
    public $API; // Объект VK API
    public $buttons; // Объект кнопок клавиатуры

    /**
     * Конструктор клавиатуры
     * 
     * @param VK $API - объект VK API
     * [@param Buttons $buttons = null] - объект кнопок клавиатуры
     */
    public function __construct (VK $API, Buttons $buttons = null)
    {
        $this->API     = $API;
        $this->buttons = $buttons ?: new Buttons;
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
        return [
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
        return json_encode ([
            'one_time' => $oneTime,
            'buttons'  => $this->buttons->toArray ()
        ]);
    }

    /**
     * Отправка сообщения с клавиатурой
     * 
     * @param int $peerID             - peer ID получателя
     * @param string $message         - сообщение
     * [@param array $params = []]    - массив дополнительных параметров методы messages.send
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
}
