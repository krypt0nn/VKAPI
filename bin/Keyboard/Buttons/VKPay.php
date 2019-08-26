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
     * @param string $hash           - конфигурация оплаты VK Pay
     * [@param string $payload = ''] - нагрузка кнопки
     */
    public function __construct (string $hash, string $payload = '')
    {
        $this->action = [
            'type'    => 'vkpay',
            'hash'    => $hash,
            'payload' => $payload
        ];
    }
}
