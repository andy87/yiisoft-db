<?php

use andy87\yii2\common\models\DataBase;
use andy87\yii2\console\controllers\DbController;

class_alias(DataBase::class, 'andy87\yii2\common\models');
class_alias(DbController::class, 'andy87\yii2\console\controllers');