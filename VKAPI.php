<?php

/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * @package     VKAPI
 * @copyright   2019 - 2020 Podvirnyy Nikita (Observer KRypt0n_)
 * @license     GNU GPLv3 <https://www.gnu.org/licenses/gpl-3.0.html>
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

const API_VERSION      = '5.103'; // Версия VK API
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

require 'bin/Core.php';
require 'bin/Method.php';
require 'bin/LongPoll.php';
require 'bin/Keyboard.php';
require 'bin/Carousel.php';

# Клавиатура
require 'bin/Keyboard/Button.php';
require 'bin/Keyboard/Buttons.php';

require 'bin/Keyboard/Buttons/Location.php';
require 'bin/Keyboard/Buttons/Text.php';
require 'bin/Keyboard/Buttons/VKApps.php';
require 'bin/Keyboard/Buttons/VKPay.php';
require 'bin/Keyboard/Buttons/OpenLink.php';

# Карусель
require 'bin/Carousel/Element.php';

require 'bin/Carousel/Elements/Text.php';
require 'bin/Carousel/Elements/Photo.php';
