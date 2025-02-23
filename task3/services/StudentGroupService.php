<?php

namespace task3\services;

use Doctrine\ORM\EntityManager;
use task3\dto\StudentGroupDto;
use task3\entities\StudentGroupEntity;
use task3\entities\GroupEntity;
use task3\entities\StudentEntity;
use Throwable;

class StudentGroupService
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param StudentGroupDto $studentGroupDto
     * @return void
     */
    public function create(StudentGroupDto $studentGroupDto): void
    {
        $studentId = $studentGroupDto->studentId;
        $student = $this->entityManager->getRepository(StudentEntity::class)->find($studentId)
                ?? printError('Данного студента не существует');

        $groupId = $studentGroupDto->groupId;
        $group = $this->entityManager->getRepository(GroupEntity::class)->find($groupId)
                ?? printError('Данной группы не существует');

        try {
            $studentGroup = new StudentGroupEntity();

            $studentGroup->setStudent($student);
            $studentGroup->setGroup($group);

            $this->entityManager->persist($studentGroup);
            $this->entityManager->flush();
        } catch (Throwable) {
            printError('Студент уже состоит в данной группе');
        }
    }

    /**
     * @param int $groupId
     * @return array
     */
    public function getStudentsList(int $groupId): array
    {
        $list = $this->entityManager->getRepository(StudentGroupEntity::class)->getStudentsList($groupId);

        if (empty($list)) {
            printError('Список студентов для данной группы не найден');
        }

        return $list;
    }

    /**
     * @param int $studentId
     * @return array
     */
    public function getGroupsList(int $studentId): array
    {

        $list = $this->entityManager->getRepository(StudentGroupEntity::class)->getGroupsList($studentId);

        if (empty($list)) {
            printError('Список групп для данного студента не найден');
        }

        return $list;
    }

    /**
     * @return array
     */
    public function getFullInformation(): array
    {
        return $this->entityManager->getRepository(StudentGroupEntity::class)->getFullInformation();
    }
}