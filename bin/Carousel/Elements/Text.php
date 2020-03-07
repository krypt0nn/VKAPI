<?php

namespace VKAPI\Carousel;

use VKAPI\{
    Element,
    Buttons
};

/**
 * Текстовый элемент карусели
 */
class Text extends Element
{
    public string $title; // Заголовок элемента
    public string $description; // Описание элемента
    
    /**
     * Конструктор элемента
     * 
     * @param string $title                - заголовок элемента
     * [@param string $description = null] - описание элемента
     * [@param Buttons $buttons = null]    - кнопки элемента
     */
    public function __construct (string $title, string $description = null, Buttons $buttons = null)
    {
        $this->title = $title;
        $this->description = $description ?: '';

        $this->buttons = $buttons ?: new Buttons;
    }

    /**
     * Получение массива представления элемента
     * 
     * @return array
     */
    public function toArray (): array
    {
        return [
            'title'       => $this->title,
            'description' => $this->description,
            'buttons'     => $this->getButtons (),
            'action'      => $this->action
        ];
    }
}
