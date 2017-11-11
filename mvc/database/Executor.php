<?php
/**
 * User: joel-haeberli
 * Date: 11.11.17
 * Time: 14:58
 */

class Executor
{
    private $connection;

    public function __construct($connection)
    {
        $this->connection = $connection;
    }

    protected function executeQuery($query, $params = []) {

        $stmt = $this->prepareStatement($query);
        $stmt->execute($params);

        $result = array();
        while ($record = $stmt->fetch()) {
            $result[] = $record;
        }
        return $result;
    }

    private function prepareStatement($query) {
        return $this->connection->prepare($query);
    }

}