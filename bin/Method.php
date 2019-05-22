<?php

namespace VKAPI;

/**
 * Метод VK API
 */
class Method
{
    protected $API; // API-родитель
    protected $method; // Префикс метода

    /**
     * Конструктор
     * 
     * @param VK $API - API-родитель метода
     * @param string $method - префикс метода
     */
    public function __construct (VK $API, string $method)
    {
        $this->API    = $API;
        $this->method = $method;
    }

    /**
     * Вызов метода
     * 
     * @param string $action - суффикс метода
     * [@param array $params = []] - параметры метода
     * 
     * @return array|null - возвращает результат запроса
     */
    public function call (string $action, array $params = []): ?array
    {
        return $this->API->request ($this->method .'.'. $action, $params);
    }

    /**
     * Алиас метода call
     * 
     * @param string $name
     * @param array $params
     * 
     * @return array|null
     */
    public function __call (string $name, array $params): ?array
    {
        return $this->call ($name, $params);
    }
}
