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

    /**
     * @param $query a Statement which can be prepared
     * @param $resultType the expected result Type (example: 'User')
     * @param $isList if the result should be a list of objects or not (true||false)
     * @param array $params the query parameter
     * @return DataObject from Type $resultType
     */
    public function executeQuery($query, $resultType, $params = []) {

        $stmt = $this->prepareStatement($query);
        $stmt->execute($params);

        $result = array();
        while ($record = $stmt->fetch()) {
            $result[] = $record;
        }
        return DataObjectMapper::resultToDataObject($resultType,$result);
    }

    private function prepareStatement($query) {
        return $this->connection->prepare($query);
    }

}