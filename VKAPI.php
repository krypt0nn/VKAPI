<?php

/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * @package     VKAPI
 * @copyright   2019 - 2021 Podvirnyy Nikita (Observer KRypt0n_)
 * @license     GNU GPL-3.0 <https://www.gnu.org/licenses/gpl-3.0.html>
 * @author      Podvirnyy Nikita (Observer KRypt0n_)
 * 
 * Contacts:
 *
 * Email: <suimin.tu.mu.ga.mi@gmail.com>
 * VK:    <https://vk.com/technomindlp>
 *        <https://vk.com/hphp_convertation>
 * 
 */

namespace VKAPI;

const API_VERSION      = '5.130'; // Версия VK API
const LONGPOLL_VERSION = '3'; // Версия LongPoll API

# Список официальных приложений для прямой авторизации
const AUTH_SERVERS = [
    ['2274003', 'hHbZxrka2uZ6jB1inYsH'],
    ['3140623', 'VeWdmVclDCtn6ihuP1nt'],
    ['3682744', 'mY6CDUswIVdJLCD3j15n'],
    ['3697615', 'AlVXZFMUqyrnABp8ncuU'],
    ['3502557', 'PEObAuQi6KloPM4T30DV']
];

# Список запросов прав доступа к API по умолчанию
const DEFAULT_SCOPE = 'notify,friends,photos,audio,video,stories,pages,status,notes,messages,wall,offline,docs,groups,email';

require 'src/Core.php';
require 'src/Method.php';
require 'src/LongPoll.php';
require 'src/Callback.php';
require 'src/Keyboard.php';
require 'src/Carousel.php';
require 'src/Bot.php';

# Клавиатура
require 'src/Keyboard/Button.php';
require 'src/Keyboard/Buttons.php';

require 'src/Keyboard/Buttons/Location.php';
require 'src/Keyboard/Buttons/Text.php';
require 'src/Keyboard/Buttons/VKApps.php';
require 'src/Keyboard/Buttons/VKPay.php';
require 'src/Keyboard/Buttons/OpenLink.php';

# Карусель
require 'src/Carousel/Element.php';

require 'src/Carousel/Elements/Text.php';
require 'src/Carousel/Elements/Photo.php';
