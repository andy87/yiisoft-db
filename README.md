<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">Yii 2 DB</h1>
    Вспомогательные контроллер + модель для обращений в BD
    <hr>
</p>
composer.json  

```
"require": {
    ...
    "andy87/yiisoft-common-db" : "1.0.1"
},
...
"repositories": [
    ...,
    {
        "type"                  : "package",
        "package"               : {
            "name"                  : "andy87/yiisoft-common-db",
            "version"               : "1.0.1",
            "source"                : {
                "type"                  : "git",
                "reference"             : "master",
                "url"                   : "https://github.com/andy87/yiisoft-common-db"
            },
            "autoload": {
                "classmap": ["src/"],
                "files": ["mapper.php"]
            }
        }
    }
]
```
<hr>

<br>

### Консольные команды

 `php yii db/tables`  
Вывести имена всех таблиц



#####Методы требующие подтверждения
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

### Методы модели  

#####DataBase  
 `getDataBaseName()` - возвращает имя базы данных текущей BD  
 `getAllTables()` - возвращает массив имён таблиц из текущей BD  

 `dropTable( $tableNames, $filter )`  
 - Удалить все таблицы ***$tableNames***  
 - при ***$filter = true*** удалятся все таблицы кроме $filter  

 `truncateTable( $tableNames, $filter )`  
 - Очистить все таблицы по условию ***$tableNames***  
 - при ***$filter = true*** очистятся все таблицы кроме $filter  
 
 Вспомогательные методы:  
 `argumentTables( $tableNames )`  
 <small>**$tableNames** = **string|null**</small>  
 возвращает массив имён таблиц из текущей BD по условию:  
    Если $tableNames = string и:    
- содержет `,` то вернёт `[ 'foo','bar' ]`  
<small>**при $tableNames == 'foo,bar'**</small> 
- не содержет `,` то  вернёт `[ 'user' ]`   
<small>**при $tableNames == 'user'**</small> 

    Если ***$tableNames = null*** вернёт список всех таблиц
    
 `query( $sql )` - выполнить запрос `$sql` и не возвращать ответ  
 `queryScalar()` - выполнить запрос `$sql` и вернуть **Scalar** ответ  
 `queryColumn()` - выполнить запрос `$sql` и вернуть **Column** ответ  
