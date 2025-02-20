<?php

namespace task3\repository;

use Doctrine\ORM\EntityRepository;

class StudentGroupRepository extends EntityRepository
{
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

    public function getFullInformation(): array
    {
        return $this->createQueryBuilder('sg')
            ->select('st, gr')
            ->innerJoin('sg.groupId', 'gr')
            ->innerJoin('sg.studentId', 'st')
            ->getQuery()
            ->getResult();
    }
}