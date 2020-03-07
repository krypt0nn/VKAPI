<?php

namespace VKAPI;

/**
 * Класс карусели
 * 
 * Представляет возможность отправки сообщений со встроенной каруселью
 * @link https://vk.com/dev/bot_docs_templates?f=5.1.%2BКарусели
 * 
 * @example
 * 
 * use VKAPI\Carousel\Text;
 * 
 * $item = new Text ('Hello, World!', 'Example item');
 * 
 * $carousel = new Carousel (new VK ('...')); // токен доступа сообщества
 * $carousel->add ($item);
 * 
 * $carousel->send ('...', 'Hello, World!'); // peer id получателя
 */
class Carousel
{
    public VK $API; // Объект VK API
    protected array $elements = []; // Список элементов карусели

    /**
     * Конструктор карусели
     * 
     * @param VK $API - объект VK API
     * [@param array $elements = []] - список элементов для карусели
     */
    public function __construct (VK $API, array $elements = [])
    {
        $this->API = $API;

        foreach ($elements as $id => $element)
            if ($element instanceof Element)
                $this->elements[] = $element;

            else throw new \Exception ('Array of elements must contain only Carousel Elements, '. get_class ($element) .' processed at index '. $id);
    }

    /**
     * Добавить элемент в карусель
     * 
     * @param Element $element - элемент для добавления
     * 
     * @return Carousel
     */
    public function add (Element $element): Carousel
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Добавить элемент в карусель по заданному индексу
     * 
     * @param int $id          - индекс для добавления
     * @param Element $element - элемент для добавления
     * 
     * @return Carousel
     */
    public function set (int $id, Element $element): Carousel
    {
        $this->elements[$id] = $element;

        return $this;
    }

    /**
     * Удаление элемента из карусели
     * 
     * @param int $id - индекс элемента
     * 
     * @return Carousel
     */
    public function remove (int $id): Carousel
    {
        unset ($this->carousel[$id]);

        return $this;
    }

    /**
     * Получение списка элементов или самого элемента
     * 
     * [@param int $id = null] - индекс элемента для получения
     * 
     * @return mixed
     */
    public function get (int $id = null)
    {
        return $id === null ?
            $this->elements : $this->elements[$id];
    }

    /**
     * Отправка сообщения с каруселью
     * 
     * @param int $peerID          - peer ID получателя
     * @param string $message      - сообщение
     * [@param array $params = []] - массив дополнительных параметров метода messages.send
     * 
     * @return array - возвращает ответ метода
     */
    public function send (int $peerID, string $message, array $params = []): array
    {
        return $this->API->messages->send (array_merge ([
            'peer_id'   => $peerID,
            'message'   => $message,
            'random_id' => rand (PHP_INT_MIN, PHP_INT_MAX),
            'template'  => $this->toJson ()
        ], $params));
    }

    /**
     * Получение массива карусели
     * 
     * @return array
     */
    public function toArray (): array
    {
        return [
            'type'     => 'carousel',
            'elements' => array_map (fn ($element) => $element->toArray (), $this->elements)
        ];
    }

    /**
     * Получение JSON массива карусели
     * 
     * @return string
     */
    public function toJson (): string
    {
        return json_encode ($this->toArray ());
    }
}
