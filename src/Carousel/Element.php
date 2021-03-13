<?php

namespace VKAPI;

use VKAPI\Buttons;

/**
 * Базовый класс реализации элемента карусели
 */
abstract class Element
{
    # Действие элемента (т.к. оно обязательно должно быть указано - по умолчанию это открытие github репозитория данной библиотеки)
    public array $action = ['type' => 'open_link', 'link' => 'https://github.com/KRypt0nn/VKAPI'];
    public Buttons $buttons; // Объект представления кнопок карусели

    /**
     * Установить действие элементу
     * 
     * @param array $action - описание действия
     * 
     * @return Element
     */
    public function setAction (array $action): Element
    {
        $this->action = $action;
        
        return $this;
    }

    /**
     * Получение массива кнопок элемента
     * 
     * @return array
     */
    public function getButtons (): array
    {
        $actions = [];

        foreach ($this->buttons->toArray () as $buttons)
            foreach ($buttons as $button)
                $actions[] = ['action' => $button['action']];
        
        return $actions;
    }

    /**
     * Получение массива представления элемента
     * 
     * @return array
     */
    public function toArray (): array
    {
        return [
            'buttons' => $this->getButtons (),
            'action'  => $this->action
        ];
    }

    /**
     * Получение JSON массива представления элемента
     * 
     * @return string
     */
    public function toJson (): string
    {
        return json_encode ($this->toArray ());
    }
}
