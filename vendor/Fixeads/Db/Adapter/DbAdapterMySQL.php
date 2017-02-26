<?php

namespace Fixeads\Db\Adapter;

use Fixeads\Util\Iterator\Collection;

class DbAdapterMySQL extends \PDO implements DbInterface
{
    public function __construct(array $config)
    {
        $dsn = "mysql:dbname={$config['dbname']};host={$config['host']}";
        parent::__construct($dsn, $config['username'], $config['passwd']);

        $this->setAttribute(self::ATTR_DEFAULT_FETCH_MODE, self::FETCH_ASSOC);
    }

    public function insert($table, array $fields)
    {
        $columns = '';
        $values = '';
        $newFields = [];

        foreach($fields as $column => $value) {
            if(!empty($value)) {
                $columns .= "$column,";
                $values .= ":$column,";
                $newFields[$column] = $value;
            }
        }

        $columns = substr($columns,0, strlen($columns)-1);
        $values = substr($values,0, strlen($values)-1);

        $sql = "INSERT INTO $table ($columns) VALUES ($values)";

        $stmt = $this->prepare($sql);
        $stmt->execute($newFields);

        //var_dump($stmt->debugDumpParams());

        $error = $this->errorInfo();
        if(!empty($error[2]))
            trigger_error($error[2], E_USER_ERROR);

        return $this->lastInsertId();
    }

    public function select($table, $cols = '*', $where = [])
    {
        $cols = is_array($cols) ? implode(',', $cols) : $cols;

        $condition = '';
        foreach ($where as $key => $value)
            $condition .= (empty($condition) ? '' : ' AND ') . "$key=:$key";

        $sql = "SELECT $cols FROM $table " . (empty($where) ? '' : "WHERE $condition");

        $stmt = $this->prepare($sql);
        foreach ($where as $key => $value)
            $stmt->bindParam(":$key", $value);
        $stmt->execute();

        return new Collection($stmt->fetchAll());
    }

    public function getFields($table)
    {
        $sql = "DESCRIBE $table;";

        $stmt = $this->query($sql);

        $results = $stmt->fetchAll();

        $metadata = array();

        foreach($results as $result) {
            if($result['Extra'] != 'auto_increment')
                $metadata[$result['Field']] = null;
        }

        return $metadata;
    }
}
