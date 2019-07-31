### Использование библиотеки

Библиотека предназначена для констурирования vk запросов в javascript execute код.

### Подключение

```php
require __DIR__.'/../vendor/autoload.php';

use SMITExecute\Library\ExecuteRequest;

$builder = new ExecuteRequest(); // Конструктор ваших execut'ов
```

### Пример использования

```php
// Добавляем в запросы execut'a messages.getConversations
$builder->add(
        $builder->create()
        ->setMainMethod("messages")
        ->setSubMethod("getConversations")
        ->setParams([
            "user_id" => 89481221
        ])
);

// Добавляем ещё один запрос users.get
$builder->add(
    $builder->create()
        ->setMainMethod("users")
        ->setSubMethod("get")
        ->setParams([
            "user_id" => 89481221,
        ])
);

$code_strings = $builder->convertToJS(); // Конвертируем код в javascript (Возвращает массив строк javascript'a)
$code = implode(PHP_EOL, $code_strings); // Преобразовываем массив в строки.

$vk = new VKApiClient('5.00');
$response = $vk->getRequest()->post('execute', "token", [
    'code' => $code,
]);
```

### Парсинг ответов от сервера.

_Библиотека конвертирует и группирует ваши запросы в объект, который возвращается с ключом *главныйМетод_сабМетод*_

### Пример ответа из примера выше

```json

{
  "messages_getConversations": [
      {
          "count" : 1,
          "items" : [
              {
                  "conversation" : {
                      "peer" : {
                          "id" : 89481221,
                          "type" : "user",
                          "local_id" : 89481221
                      },
                      "in_read" : 5,
                      "out_read":5,
                      "last_message_id":5,
                      "can_write":
                          {
                            "allowed" : true
                          },
                      "current_keyboard" : {
                          "one_time":true,
                          "author_id":-184452841,
                          "buttons":[
                              ["Over 9 levels deep, aborting normalization"]
                          ]
                      }
                  },
                  "last_message" : {
                      "date" : 1564532387,
                      "from_id" : -184452841,
                      "id" : 5,
                      "out" : 1,
                      "peer_id" : 89481221,
                      "text" : "хай",
                      "conversation_message_id" : 5,
                      "fwd_messages" : [],
                      "keyboard": {
                          "one_time":true,
                          "author_id":-184452841,
                          "buttons": [
                              ["Over 9 levels deep, aborting normalization"]
                          ]
                      },
                      "important":false,
                      "random_id":0,
                      "attachments":[],
                      "is_hidden":false
                  }
              }
          ]
      }
  ],
                            
  "users_get":[
    [
      {
        "id":89481221,
        "first_name":"Андрей",
        "last_name":"Кутин"
      }
    ]
  ]
}

```

_Как вы могли заметить ваши запросы будут группироваться по их типам, все запросы будут представлены массивом ответов от серверов вконтакте_

_Конкретный пример использования вы можете посмотреть [здесь](https://github.com/n0tm/VkExecuteBuilder/tree/master/examples)._
