<?php

namespace VKAPI;

/**
 * Класс кнопок клавиатуры
 */
class Buttons
{
    protected $buttons = []; // Массив кнопок

    /**
     * Добавление кнопки
     * 
     * @param int $row       - ряд для добавления (начиная с 0)
     * @param Button $button - кнопка для добавления
     * 
     * @return Buttons - возвращает сам себя
     * 
     * @throws \Exception - выбрасывает исключения при нарушении размеров клавиатуры
     */
    public function add (int $row, Button $button): Buttons
    {
        if ($row < 0 || $row > 9)
            throw new \Exception ('$row param must be in range [0; 9]');

        if (sizeof ($this->buttons) == 4)
            throw new \Exception ('You can not set more than 4 buttons in one row');
        
        $this->buttons[$row][] = $button;

        return $this;
    }

    /**
     * Установка кнопки
     * 
     * @param int $row       - ряд для установки (начиная с 0)
     * @param int $column    - колонна для установки (начиная с 0)
     * @param Button $button - кнопка для установки
     * 
     * @return Buttons - возвращает сам себя
     * 
     * @throws \Exception - выбрасывает исключения при выход за размеры клавиатуры
     */
    public function set (int $row, int $column, Button $button): Buttons
    {
        if ($row < 0 || $row > 9)
            throw new \Exception ('$row param must be in range [0; 9]');

        if ($column < 0 || $column > 3)
            throw new \Exception ('$column param must be in range [0; 3]');
        
        $this->buttons[$row][$column] = $button;

        return $this;
    }

    /**
     * Удаление кнопки или ряда
     * 
     * @param int $row             - ряд для удаления (начиная с 0)
     * [@param int $column = null] - колонная для удаления (начиная с 0)
     * 
     * @return Buttons - возвращает сам себя
     */
    public function remove (int $row, int $column = null): Buttons
    {
        if ($column === null)
            unset ($this->buttons[$row]);

        else unset ($this->buttons[$row][$column]);

        return $this;
    }

    /**
     * Получение массива кнопок
     * 
     * @return array - возвращает массив кнопок
     */
    public function toArray (): array
    {
        return array_map (function ($row)
        {
            return array_map (function ($column)
            {
                return $column->toArray ();
            }, $row);
        }, $this->buttons);
    }

    /**
     * Получение JSON массива кнопок
     * 
     * @return string - возвращает JSON массив кнопок
     */
    public function toJson (): string
    {
        return json_encode (array_map (function ($row)
        {
            return array_map (function ($column)
            {
                return $column->toArray ();
            }, $row);
        }, $this->buttons));
    }
}
