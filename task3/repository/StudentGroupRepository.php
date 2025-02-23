<?php

namespace task3\repository;

use Doctrine\ORM\EntityRepository;

class StudentGroupRepository extends EntityRepository
{
    /**
     * Запрос для получения списка студентов для определённой группы
     * @param int $groupId
     * @return array
     */
    public function getStudentsList(int $groupId): array
    {
       return $this->createQueryBuilder('sg')
            ->select('st.lastName, st.firstName, gr.groupName')
            ->innerJoin('sg.groupId', 'gr')
            ->innerJoin('sg.studentId', 'st')
            ->where('gr.id = :groupId')
            ->setParameter('groupId', $groupId)
           ->getQuery()
           ->getResult();
    }

    /**
     * Запрос для получения списка групп для определённого студента
     * @param int $studentId
     * @return array
     */
    public function getGroupsList(int $studentId): array
    {
        return $this->createQueryBuilder('sg')
            ->select('st.lastName, st.firstName, gr.groupName, gr.groupType')
            ->innerJoin('sg.groupId', 'gr')
            ->innerJoin('sg.studentId', 'st')
            ->where('st.id = :studentId')
            ->setParameter('studentId', $studentId)
            ->getQuery()
            ->getResult();
    }

    /**
     * Запрос для получения всей информации
     * @return array
     */
    public function getFullInformation(): array
    {
        return $this->createQueryBuilder('sg')
            ->select('sg, gr, st')
            ->innerJoin('sg.groupId', 'gr')
            ->innerJoin('sg.studentId', 'st')
            ->getQuery()
            ->getResult();
    }
}