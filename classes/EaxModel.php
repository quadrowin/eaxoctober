<?php namespace Quadrowin\EaxOctober\Classes;

use October\Rain\Database\Model;

abstract class EaxModel extends Model
{

    use InsertOnDuplicateKey;

    /**
     * @var array
     */
    private static $modelsServices = [];

    /**
     * @param string $class
     * @return Model
     */
    private static function getModelService(string $class): Model
    {
        if (empty(self::$modelsServices[$class])) {
            self::$modelsServices[$class] = new $class;
        }
        return self::$modelsServices[$class];
    }

    /**
     * Begin querying the model.
     *
     * @param string
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|EaxModelQuery
     */
    public static function qry(string $alias)
    {
        return static::qryFor(static::class, $alias);
    }

    /**
     * @param string $class
     * @param string $alias
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder|EaxModelQuery
     */
    public static function qryFor(string $class, string $alias)
    {
        /** @var Model $model */
        $model = new $class;
        $table = $model->getTable();
        $model->setTable($alias);
        /** @var \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder $query */
        $query = $model->newQuery()->from($table . ' as ' . $alias);
        $query->macro('toSqlDie', function () use ($query) {
            vd($query->toSql(), $query->getBindings());
        });
        $query->macro('toSqlDump', function () use ($query) {
            echo '<!-- ' . $query->toSql() . ' --- ' . json_encode($query->getBindings()) .  ' -->';
            return $query;
        });
        return $query;
    }

    /**
     * Возвращает часть запроса "название_таблицы AS $alias"
     * @param string $alias
     * @return string
     */
    public static function tableAs(string $alias): string
    {
        $model = self::getModelService(static::class);
        return $model->getTable() . ' as ' . $alias;
    }

    /**
     * Возвращает часть запроса "название_таблицы AS $alias"
     * @param string $class
     * @param string $alias
     * @return string
     */
    public static function tableAsFor(string $class, string $alias): string
    {
        $model = self::getModelService($class);
        return $model->getTable() . ' as ' . $alias;
    }

}