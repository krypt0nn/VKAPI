<?php

namespace VKAPI\Buttons;

use VKAPI\Button;

/**
 * Кнопка с текстом
 */
class Text extends Button
{
    /**
     * Конструктор
     * 
     * @param string $label         - текст кнопки
     * [@param array $payload = []] - нагрузка кнопки
     */
    public function __construct (string $label, array $payload = [])
    {
        $this->action = [
            'type'    => 'text',
            'label'   => $label,
            'payload' => $payload
        ];
    }
}
