<?php

namespace VKAPI\Buttons;

use VKAPI\Button;

/**
 * Кнопка передачи геолокации
 */
class Location extends Button
{
    /**
     * Конструктор
     * 
     * [@param array $payload = []] - нагрузка кнопки
     */
    public function __construct (array $payload = [])
    {
        $this->action = [
            'type'    => 'location',
            'payload' => $payload
        ];
    }
}
