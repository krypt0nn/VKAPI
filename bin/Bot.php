<?php

namespace VKAPI;

/**
 * Объект реализации элементарного чат бота
 * 
 * Коллбэк обработки новых сообщений принимает в качестве параметра массив, получаемый методом messages.getById
 * @link https://vk.com/dev/messages.getById
 * 
 * Соответственно, токен VK API должен иметь доступ к messages
 */
class Bot
{
    public LongPoll $longpoll; // Объект LongPoll для получения обновлений

    protected int $selfId; // ID пользователя, от которого получаются обновления
    protected $callback = null; // Коллбэк обработки новых сообщений

    /**
     * Конструктор бота
     * 
     * @param LongPoll $longpoll - LongPoll, от которого идут обновления
     * [@param callable $callable = null] - коллбэк обработки новых сообщений
     * 
     * @throws \Exception - выбрасывает исключение при нерабочем токене VK API
     * 
     * @example
     * 
     * $bot = new Bot ($longpoll, function ($message)
     * {
     *     echo $message['from_id'] .' | '. $message['text'] . PHP_EOL;
     * });
     * 
     * while (true)
     *     $bot->update ();
     */
    public function __construct (LongPoll $longpoll, callable $callable = null)
    {
        $this->longpoll = $longpoll;
        $this->callback = $callable;

        try
        {
            $this->selfId = @$longpoll->API->users->get ()['response'][0]['id'] ?? -1; 

            # Если $this->selfId равен -1 - токен доступа либо недоступен,
            # либо он принадлежит сообществу
            if ($this->selfId === -1)
            {
                # Пробуем получить информацию о сообществе
                $id = @$longpoll->API->groups->getById ()['response'][0]['id'];
                
                # Если токен принадлежит сообществу - $id будет int,
                # иначе токен недействителен и код выкинет ошибку из блока catch ниже
                $this->selfId = $id !== null ?
                    - $id : null;
            }
        }

        catch (\Throwable $e)
        {
            throw new \Exception ('Wrong VK API token');
        }
    }

    /**
     * Установка / получение коллбэка обработки сообщений
     * 
     * [@param callable $callable = null] - коллбэк для установки (только если указан)
     * 
     * @return callable|null - возвращает актуальный коллбэк обработки сообщений
     */
    public function callback (callable $callable = null): ?callable
    {
        if ($callable !== null)
            $this->callback = $callable;
        
        return $this->callback;
    }

    /**
     * Обновление LongPoll и обработка новых сообщений
     * 
     * [@param callable $callable = null] - коллбэк обработки сообщений
     * Если не указан - используется коллбэк из параметра callback
     * 
     * @return Bot - возвращает самого себя
     */
    public function update (callable $callable = null): Bot
    {
        $callable ??= $this->callback ();

        # Получение обновлений
        try
        {
            $updates = $this->longpoll->getUpdates ();
        }

        catch (\Throwable $e)
        {
            # Обновление LongPoll если он оказался нерабочим (сервера сменили или ещё чего~)
            $this->longpoll = new LongPoll ($this->longpoll->API);

            $updates = $this->longpoll->getUpdates ();
        }

        # Завершаем работу если не указан обработчик сообщений
        if ($callable === null)
            return $this;

        # Получение обновлений, связанных с новыми сообщениями
        $ids = [];

        foreach ($updates as $update)
            if ($update[0] == 4)
                $ids[] = $update[1];

        # Обработка сообщений
        while (sizeof ($ids) > 0)
        {
            # Получение подробной информации о сообщении
            $messages = $this->longpoll->API->messages->getById ([
                'message_ids' => implode (',', array_slice ($ids, 0, 100))
            ])['response']['items'] ?? [];

            $ids = array_slice ($ids, 100);

            # Проход по всем сообщениям
            foreach ($messages as $info)
            {
                # Фильтр сообщений от бота
                if ($info['from_id'] == $this->selfId)
                    continue;

                # Вызов коллбэка обработки
                $callable ($info);
            }
        }

        return $this;
    }
}
