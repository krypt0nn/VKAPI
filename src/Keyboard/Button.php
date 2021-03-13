<?php

namespace VKAPI;

/**
 * Базовый класс реализации кнопки клавиатуры
 */
abstract class Button
{
    protected array $action = []; // Параметры кнопки

    /**
     * Получение массива кнопки
     * 
     * @return array - возвращает массив кнопки
     */
    public function toArray (): array
    {
        return ['action' => $this->action];
    }

    /**
     * Получение JSON массива кнопки
     * 
     * @return string - возвращает JSON массив кнопки
     */
    public function toJson (): string
    {
        return json_encode ($this->toArray ());
    }
}
