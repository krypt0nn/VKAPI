<h1 align="center">🔥 VKAPI 🔥</h1>

**VKAPI** - библиотека для упрощённой работы с API ВКонтакте на PHP 7.4

### Установка

```cmd
php qero.phar i KRypt0nn/VKAPI
```

[Что такое Qero?](https://github.com/KRypt0nn/Qero)

```php
<?php

use VKAPI\VK;

require 'qero-packages/autoload.php';

// ...
```

Для ручной установки необходимо распаковать библиотеку в удобное для Вас место и подключить файл ``VKAPI.php``

### Авторизация

```php
<?php

use VKAPI\VK;

$API = new VK ('логин', 'пароль');

print_r ($API->users->get ([
    'user_ids' => 1
]));

print_r ($API->users->get ()); // Сам себя~
```

### Авторизация с поддержкой 2ФА

```php
<?php

use VKAPI\VK;

$API = new VK ('логин', 'пароль', function ()
{
    // Читаем и возвращаем 2ФА код, который ввёл пользователь (в консоль)
    return readline ('2fa code: ');
});
```

### Авторизация с токеном доступа

```php
<?php

use VKAPI\VK;

$API = new VK ('токен доступа');
```

### LongPoll API

```php
<?php

namespace VKAPI;

$API      = new VK ('логин', 'пароль');
$longpoll = new LongPoll ($API);

while (true)
    if (sizeof ($updates = $longpoll->getUpdates ()) > 0)
        print_r ($updates);
```

### Чат бот

```php
<?php

namespace VKAPI;

$API      = new VK ('логин', 'пароль');
$longpoll = new LongPoll ($API);

$bot = new Bot ($longpoll, function ($message)
{
    echo $message['from_id'] .' | '. $message['text'] . PHP_EOL;
});

while (true)
    $bot->update ();
```

## Функционал сообществ

### Клавиатура

```php
<?php

namespace VKAPI;

use VKAPI\Buttons\Text;

# true - сделать ли клавиатуру встроенной в сообщение (inline клавиатура)
$keyboard = new Keyboard (new VK ('токен сообщества'), true);

# 0 - первый ряд
$keyboard->buttons->add (0, new Text ('Hello, World!'));

# 1 - второй ряд
$keyboard->buttons->add (1, (new Text ('Yes'))->setColor ('positive'));
$keyboard->buttons->add (1, (new Text ('No'))->setColor ('negative'));

// []   - дополнительные параметры message.send
// true - клавиатура будет отображена всего 1 раз
$keyboard->send ('peer id', 'Тесто', [], true);
```

### Карусель

```php
<?php

namespace VKAPI;

use VKAPI\Carousel\Text;

$carousel = new Carousel (new VK ('токен сообщества'));

# Создаём элемент для карусели
$element = new Text ('Привет, Мир!', 'Тестовый элемент карусели');
$element->buttons->add (new Buttons\Text ('Я просто кнопка~~'));

# Добавляем элемент в карусель
$caruosel->add ($element);

# Отправка карусели. Указать peer id получателя и сообщение для отправки
$carousel->send ('peer id', 'Привет! Я тут карусель сделал, не посмотришь?');
```

Автор: [Подвирный Никита](https://vk.com/technomindlp). Специально для [Enfesto Studio Group](https://vk.com/hphp_convertation)
