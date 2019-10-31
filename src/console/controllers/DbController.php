<?php

namespace andy87\yii2\console\controllers;

use yii\db\Exception;
use yii\console\Controller;

use andy87\yii2\common\models\DataBase;

/**
 * Class DbController
 *
 *      Controller
 */
class DbController extends Controller
{
    const TABLE_MIGRATION   = 'migration';
    const TABLE_USER        = 'user';

    public $accept          = ['y', 'yes'];

    public $accessErr       = 'Нужно подтверждение: y';


    /**
     * Void
     */
    public function actionTables()
    {
        $tables = DataBase::getAllTables();

        foreach ( $tables as $table ) echo "\r\n {$table}";
    }

    /**
     * @param string|bool $accept
     * @param string|null $tableNames
     * @param boolean $filter
     *
     * @throws Exception
     */
    public function actionReset( $accept = 'y', $tableNames = null, $filter = false )
    {
        $this->access($accept);

        $texts = DataBase::dropTable( $tableNames, $filter );

        foreach ( $texts as $text ) echo "\r\n {$text}";
    }

    /**
     * @param string|bool $accept
     * @param string|null $tableNames
     * @param boolean $filter
     *
     * @throws Exception
     */
    public function actionDelete( $accept = false, $tableNames = null, $filter = false )
    {
        self::actionReset($accept = false, $tableNames = null, $filter = false);
    }

    /**
     * @param string|bool $accept
     * @param string|null $tableNames
     * @param boolean $filter
     *
     * @throws Exception
     */
    public function actionRemove( $accept = false, $tableNames = null, $filter = false )
    {
        self::actionReset($accept = false, $tableNames = null, $filter = false);
    }

    /**
     * @param string|bool $accept
     * @param string|null $tableNames
     * @param boolean $filter
     *
     * @throws Exception
     */
    public function actionTruncate( $accept = false, $tableNames = null, $filter = false )
    {
        $this->access($accept);

        $texts = DataBase::truncateTable( $tableNames, $filter );

        foreach ( $texts as $text ) echo "\r\n {$text}";
    }

    /**
     * @param string|bool $accept
     * @param string|null $tableNames
     * @param boolean $filter
     *
     * @throws Exception
     */
    public function actionClear( $accept = false, $tableNames = null, $filter = false )
    {
        $this->actionTruncate( $accept, $tableNames, $filter );
    }

    /**
     * @param string|bool $accept
     * @param string $tableName
     *
     * @throws Exception
     */
    public function actionRevert( $accept = false, $tableName = self::TABLE_MIGRATION )
    {
        $this->access($accept);

        $sql = ( $tableName == self::TABLE_MIGRATION )
            ? "DELETE FROM `migration` ORDER BY `migration`.`apply_time` DESC LIMIT 1 "
            : "DELETE FROM `{$tableName}` ORDER BY `{$tableName}`.`id` DESC LIMIT 1";

        echo ( DataBase::query($sql) )
            ? "Revert `{$tableName}` - complete"
            : "Revert `{$tableName}` - failed";
    }

    /**
     * @param string|bool $accept
     */
    private function access( $accept )
    {
        if ( !$accept OR !in_array($accept, $this->accept ) )
        {
            exit( $this->accessErr );
        }
    }
}