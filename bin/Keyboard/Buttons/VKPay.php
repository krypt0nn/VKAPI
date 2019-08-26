<?php

namespace VKAPI\Buttons;

use VKAPI\Button;

/**
 * Кнопка оплаты VK Pay
 */
class VKPay extends Button
{
    /**
     * Конструктор
     * 
     * @param string $hash          - конфигурация оплаты VK Pay
     * [@param array $payload = []] - нагрузка кнопки
     */
    public function __construct (string $hash, array $payload = [])
    {
        $this->action = [
            'type'    => 'vkpay',
            'hash'    => $hash,
            'payload' => $payload
        ];
    }
}
