<?php

namespace VKAPI\Buttons;

use VKAPI\Button;

/**
 * Кнопка открытия ссылки
 */
class OpenLink extends Button
{
    /**
     * Конструктор
     * 
     * @param string $link           - ссылка для открытия
     * [@param string $label = null] - текст кнопки (если не указать будет использован домен ссылки)
     * [@param array $payload = []]  - нагрузка кнопки
     */
    public function __construct (string $link, string $label = null, array $payload = [])
    {
        $this->action = [
            'type'    => 'open_link',
            'link'    => $link,
            'label'   => $label ?: (@parse_url ($link)['host'] ?? $link),
            'payload' => $payload
        ];
    }
}
