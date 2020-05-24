<?php
namespace classes\Services;


class GetData
{
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    //TODO fix to clear state of QueryBuilder coz all
    public function __get($property) {
        if($property == 'qb'){
            $this->qb = $this->conn->createQueryBuilder();
        }
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTaskListObject($id){
        $this->qb = $this->conn->createQueryBuilder();
        return $this->qb->select('*')
            ->from('srv.get_list_task('.$id.')')
            ->execute()
            ->fetchAll(\Doctrine\DBAL\FetchMode::ASSOCIATIVE);

    }

    /**
     * @param $task_id
     * @return mixed
     */
    public function getQuestionListByTask($task_id){
        $this->qb = $this->conn->createQueryBuilder();

        return $this->qb->select('*')
            ->from('srv.get_list_q('.$task_id.')')
            ->execute()
            ->fetchAll(\Doctrine\DBAL\FetchMode::ASSOCIATIVE);
    }
}
