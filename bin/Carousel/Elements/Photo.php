<?php

namespace VKAPI\Carousel;

use VKAPI\{
    Element,
    Buttons
};

/**
 * Элемент карусели с фотографией
 */
class Photo extends Element
{
    public string $photo_id; // ID фотографии (обязательно разрешение 13/8)
    public ?string $title = null; // Заголовок элемента
    public ?string $description = null; // Описание элемента
    
    /**
     * Конструктор элемента
     * 
     * @param string $photo_id             - ID фотографии элемента
     * [@param string $title = null]       - заголовок для элемента
     * [@param string $description = null] - описание для элемента
     * [@param Buttons $buttons]           - кнопки элемента
     */
    public function __construct (string $photo_id, string $title = null, string $description = null, Buttons $buttons = null)
    {
        $this->photo_id    = $photo_id;
        $this->title       = $title;
        $this->description = $description;

        # По умолчанию ставим как действие открытие фотографии элемента
        $this->action = [
            'type'     => 'open_photo',
            'photo_id' => $photo_id
        ];

        $this->buttons = $buttons ?: new Buttons;
    }

    /**
     * Получение массива представления элемента
     * 
     * @return array
     */
    public function toArray (): array
    {
        $return = [
            'photo_id' => $this->photo_id,
            'buttons'  => $this->getButtons (),
            'action'   => $this->action
        ];

        if ($this->title !== null)
            $return = array_merge ($return, [
                'title'       => $this->title,
                'description' => $this->description ?? ''
            ]);

        return $return;
    }
}
