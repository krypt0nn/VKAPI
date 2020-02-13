# VKAPI

**VKAPI** - класс для упрощённой работы с API ВКонтакте на PHP 7.4

### Установка

```cmd
php qero.phar i KRypt0nn/VKAPI
```

```php
<?php

use VKAPI\VK;

require 'qero-packages/autoload.php';

// ...
```

> Qero можно посмотреть [здесь](https://github.com/KRypt0nn/Qero)

### Авторизация

```php
<?php

namespace VKAPI;

$API = new VK ('логин', 'пароль');

print_r ($API->users->get ([
    'user_ids' => 1
]));

print_r ($API->users->get ()); // Сам себя~
```

### Авторизация с поддержкой 2ФА

```php
<?php

namespace VKAPI;

$API = new VK ('логин', 'пароль', function ()
{
    // Читаем и возвращаем 2ФА код, который ввёл пользователь (в консоль)
    return readline ('2fa code: ');
});
```

### Авторизация с токеном доступа

```php
<?php

namespace VKAPI;

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

### Keyboard API

```php
<?php

namespace VKAPI;

use VKAPI\Buttons\Text;

$API = new VK ('токен доступа');

$yes = new Text ('Yes');
$yes->color = 'positive';

$no = new Text ('No');
$no->color = 'negative';

$keyboard = new Keyboard ($API);

// 0 - первый ряд
$keyboard->buttons->add (0, new Text ('Hello, World!'));

// 1 - второй ряд
$keyboard->buttons->add (1, $yes);
$keyboard->buttons->add (1, $no);

// 1    - peer ID получателя
// []   - дополнительные параметры message.send
// true - клавиатура будет отображена всего 1 раз
$keyboard->send (1, 'Тесто', [], true);
```

Автор: [Подвирный Никита](https://vk.com/technomindlp). Специально для [Enfesto Studio Group](https://vk.com/hphp_convertation)