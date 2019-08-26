<?php

namespace VKAPI\Buttons;

use VKAPI\Button;

/**
 * Кнопка запуска приложения VK App
 */
class VKApps extends Button
{
    /**
     * Конструктор
     * 
     * @param int $appID            - ID приложения
     * @param int $ownerID          - владелец приложения
     * @param string $label         - текст кнопки
     * @param string $hash          - конфигурация запуска
     * [@param array $payload = []] - нагрузка кнопки
     */
    public function __construct (int $appID, int $ownerID, string $label, string $hash, array $payload = [])
    {
        $this->action = [
            'type'     => 'open_app',
            'app_id'   => $appID,
            'owner_id' => $ownerID,
            'label'    => $label,
            'hash'     => $hash,
            'payload'  => $payload
        ];
    }
}
