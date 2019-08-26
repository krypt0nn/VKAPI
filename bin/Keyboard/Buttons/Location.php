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
     * [@param string $payload = ''] - нагрузка кнопки
     */
    public function __construct (string $payload = '')
    {
        $this->action = [
            'type'    => 'location',
            'payload' => $payload
        ];
    }
}
