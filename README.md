# VKAPI

**VKAPI** - класс для упрощённой работы с **VK API** на **PHP** 7+

```php
<?php

namespace VKAPI;

$API = new VK;
$API->auth ('логин', 'пароль');

print_r ($API->users->get ([
    'user_ids' => 1
]));

print_r ($API->users->get ()); // Сам себя~
```

### LongPoll API

```php
<?php

namespace VKAPI;

$API = new VK;
$API->auth ('логин', 'пароль');

$longpoll = new LongPoll ($API);

while (true)
    if (sizeof ($updates = $longpoll->getUpdates ()) > 0)
        print_r ($updates);
```

Автор: [Подвирный Никита](https://vk.com/technomindlp). Специально для [Enfesto Studio Group](https://vk.com/hphp_convertation)