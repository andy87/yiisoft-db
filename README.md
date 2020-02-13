<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 DB</h1>
</p>

Вспомогательные контроллер + модель для обращений в BD.   
***Задача :*** быстро очищать/удалять таблицы из консоли.
<hr>

##### INSTALL
Добавить в `composer.json`  
<small>require</small>  
```
"require": {
    ...
    "andy87/yiisoft-db" : "1.0.1"
},
```  
<small>repositories</small>  
```
"repositories": [
    ...,
    {
        "type"                  : "package",
        "package"               : {
            "name"                  : "andy87/yiisoft-db",
            "version"               : "1.0.1",
            "source"                : {
                "type"                  : "git",
                "reference"             : "master",
                "url"                   : "https://github.com/andy87/yiisoft-db"
            },
            "autoload": {
                "psr-4": {
                    "andy87\\yii2\\db\\console\\controllers\\": "src/console/controllers",
                    "andy87\\yii2\\db\\common\\models\\": "src/common/models"
                }
            }
        }
    }
]
```
выполнить: `php composer.phar update`

Создать файл `console/controllers/DbControllers.php`
```
<?php

namespace console\controllers;

class DbController extends \andy87\yii2\db\console\controllers\DbController
{
    // ...
}
```
  
<br>
  
### Консольные команды

 `php yii db/tables`  
Вывести имена всех таблиц

##### Методы требующие подтверждения
-confirm  = -y|-yes

 `php yii db/reset $confirm $tableNames $filter`  
Удалить все таблицы
  
  
 `php yii db/clear $confirm $tableNames $filter`  
Очистить все таблицы  
  
  
 `php yii db/truncate $confirm $tableNames $filter`  
Очистить все таблицы   
<small> alias db/clear </small>  

  
 `php yii db/revert $name`  
Удалить последнюю строку в таблице `name`
<small> alias db/clear </small>

 `php yii db/drop`  
Удалить все таблицы в Базе

  
<br>
  
### Методы модели  

##### DataBase  
 `getDataBaseName()` - возвращает имя базы данных текущей BD  
 `getAllTables()` - возвращает массив имён таблиц из текущей BD  

 `dropTable( $tableNames, $filter )`  
 - Удалить все таблицы ***$tableNames***  
 - при ***$filter = true*** удалятся все таблицы кроме $filter  

 `truncateTable( $tableNames, $filter )`  
 - Очистить все таблицы по условию ***$tableNames***  
 - при ***$filter = true*** очистятся все таблицы кроме $filter  
  
<br>
  
### Вспомогательные методы:  
 `argumentTables( $tableNames, $filter )`  
 <small>**$tableNames** = **string|null**</small>  
 возвращает массив имён таблиц из текущей BD по условию:  
    Если $tableNames = string и:    
- содержет `,` то вернёт `[ 'foo','bar' ]`  
<small>**при $tableNames == 'foo,bar'**</small> 
- не содержет `,` то  вернёт `[ 'user' ]`   
<small>**при $tableNames == 'user'**</small> 

Если ***$tableNames = null*** вернёт список всех таблиц  
Если ***$filter = true*** вернётся список всех таблиц кроме тех что будут в ***$tableNames***  
<br>
 `query( $sql )` - выполнит `$sql` запрос и не возвращать ответ (true|false)  
 `queryScalar( $sql )` - выполнит `$sql` запрос и вернёт стандартный ответ **Scalar**  (string|integer)  
 `queryColumn( $sql )` - выполнит `$sql` запрос и вернет стандартный ответ **Column**  (Array)  
