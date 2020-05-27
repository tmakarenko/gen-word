<?php

namespace classes\Services;


class GetData
{
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    //TODO fix to clear state of QueryBuilder coz all
    public function __get($property)
    {
        if ($property == 'qb') {
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
    public function getTaskListObject($stud_exam_id)
    {
        $this->qb = $this->conn->createQueryBuilder();
        return $this->qb->select('*')
            ->from('srv.getlist_task_by_stud_exam_id(' . $stud_exam_id . ')')
            ->execute()
            ->fetchAll(\Doctrine\DBAL\FetchMode::ASSOCIATIVE);

    }

    /**
     * @param $id
     * @return mixed
     */
    public function getTaskListById($id_array = [])
    {
        $this->qb = $this->conn->createQueryBuilder();
        return $this->qb->select('*')
            ->from('monitoring.task')
            ->where($this->qb->exp)
            ->execute()
            ->fetchAll(\Doctrine\DBAL\FetchMode::ASSOCIATIVE);

    }

    /**
     * @param $task_id
     * @return mixed
     */
    public function getQuestionListByTask($task_id,$stud_exam_id, $as_string = false)
    {
        $this->qb = $this->conn->createQueryBuilder();
        $result = '';
        $result = $this->qb->select('*')
            ->from('srv.get_list_q_w_answer(' . $task_id . ', '.$stud_exam_id.')')
            ->execute()
            ->fetchAll(\Doctrine\DBAL\FetchMode::ASSOCIATIVE);
        if ($as_string) {
            $resultText = '';
            foreach ($result as $key => $question) {
                $resultText .= str_replace('<br />', '</w:t><w:br/><w:t>', nl2br($question['q_text']));
                $resultText .= '</w:t><w:br/><w:t>';
                $resultText .= '<w:p><w:rPr> <w:b/> </w:rPr> <w:t>'.$question['sea_answer_text'].'</w:t></w:p><w:br/><w:br/>';
            }
            return $resultText;
        }
        return $result;
    }

    public function getUserInfo($stud_exam_id){
        $this->qb = $this->conn->createQueryBuilder();
        $result = '';
        $result = $this->qb->select('*')
            ->from('srv.get_user_info('.$stud_exam_id.')')
            ->execute()
            ->fetchAll(\Doctrine\DBAL\FetchMode::ASSOCIATIVE);
        return $result;
    }
}
