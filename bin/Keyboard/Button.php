<?php

namespace VKAPI;

/**
 * Базовый класс реализации кнопки клавиатуры
 */
abstract class Button
{
    public $color     = 'primary'; // Цвет кнопки (primary, secondary, positive или negative)
    protected $action = []; // Параметры кнопки

    /**
     * Установка цвета кнопки
     * 
     * @param string $color - цвет для установки (см. выше)
     * 
     * @return Button - возвращает сам себя
     */
    public function setColor (string $color): Button
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Получение массива кнопки
     * 
     * @return array - возвращает массив кнопки
     */
    public function toArray (): array
    {
        return [
            'color'  => $this->color,
            'action' => $this->action
        ];
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
