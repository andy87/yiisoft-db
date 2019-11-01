<?php

namespace andy87\yii2\db\common\models;

use Yii;
use yii\base\Model;
use yii\db\Exception;
use yii\db\DataReader;

/**
 * Class DataBase
 *
 *      Model
 */
class DataBase extends Model
{
    /**
     * @return false|string|null
     *
     * @throws Exception
     */
    public static function getDataBaseName()
    {
        $database = self::queryScalar( "SELECT DATABASE()" );

        return $database;
    }

    /**
     * @return array
     *
     * @throws Exception
     */
    public static function getAllTables()
    {
        $database   = self::getDataBaseName();
        $sql        = <<<SQL
    SELECT `table_name` FROM `information_schema`.`tables` WHERE `table_schema` = '{$database}'
SQL;
        $tables = self::queryColumn( $sql );

        return $tables;
    }

    /**
     * @param null|string $tableName
     * @param bool $filter
     * @return array
     */
    public static function getTablesCount( $tableName = null, $filter = false )
    {
        $tableNames = self::argumentTables( $tableName, $filter );

        $resp = [];

        foreach ( $tableNames as $tableName )
        {
            $count  = self::queryScalar( "SELECT count(*) FROM `$tableName`" );
            $resp[ $tableName ] = $count;
        }

        return $resp;
    }

    /**
     * @param null|string $tableName
     * @param bool $filter
     *
     * @return array
     *
     * @throws Exception
     */
    public static function  dropTable( $tableName = null, $filter = false )
    {
        $resp       = [];

        $tableNames = self::argumentTables( $tableName, $filter );

        foreach ( $tableNames as $tableName )
        {
            $sql = "DROP TABLE `{$tableName}`";

            $resp[] = ( self::query( $sql ) )
                ? "Deleted : $tableName "
                : "Not deleted : $tableName ";
        }

        return $resp;
    }

    /**
     * @param null|string $tableName
     * @param bool $filter
     *
     * @return array
     *
     * @throws Exception
     */
    public static function  truncateTable( $tableName = null, $filter = false )
    {
        $resp       = [];

        $tableNames = self::argumentTables( $tableName, $filter );

        foreach ( $tableNames as $tableName )
        {
            $sql = /** @lang sql */ "TRUNCATE `{$tableName}`";

            $resp[] = ( self::query( $sql ) )
                ? "Truncate : $tableName "
                : "Not truncate : $tableName ";
        }

        return $resp;
    }

    /**
     * @param null|string $tableName
     * @param bool $filter
     *
     * @return array
     *
     * @throws Exception
     */
    public static function argumentTables( $tableName = null, $filter = false )
    {
        $tableNames = ( !$tableName OR $filter == true )
            ? self::getAllTables()
            : self::checkList( $tableName );

        if ( $filter == true )
        {
            $filter = self::checkList( $tableName );

            foreach ( $filter as $item )
            {
                unset( $tableNames[ array_search( $item, $tableNames ) ] );
            }
        }

        return $tableNames;
    }

    /**
     * @param $str
     * @return array
     */
    private static function checkList( $str )
    {
        $arr = ( strpos($str, ',') !== false )
            ? explode(',', $str )
            : [ $str ];

        return $arr;
    }

    /**
     * @param string $sql
     *
     * @return DataReader
     *
     * @throws Exception
     */
    public static function query( string $sql )
    {
        return Yii::$app->db->createCommand( $sql )->query();
    }

    /**
     * @param string $sql
     *
     * @return false|string|null
     *
     * @throws Exception
     */
    public static function queryScalar( string $sql )
    {
        return Yii::$app->db->createCommand( $sql )->queryScalar();
    }

    /**
     * @param string $sql
     *
     * @return array
     *
     * @throws Exception
     */
    public static function queryColumn( string $sql )
    {
        return Yii::$app->db->createCommand( $sql )->queryColumn();
    }
}