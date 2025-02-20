<?php

namespace task3\controllers;

use Doctrine\ORM\EntityManager;
use task3\dto\StudentGroupDto;
use task3\services\StudentGroupService;

class StudentGroupController
{
    public StudentGroupService $studentGroupService;

    public function __construct(EntityManager $entityManager)
    {
        $this->studentGroupService = new StudentGroupService($entityManager);
    }

    public function create(array $request): void
    {
        $studentGroupDto = new StudentGroupDto();

        $studentGroupDto->studentId = $request['student_id'];
        $studentGroupDto->groupId = $request['group_id'];

        $this->studentGroupService->create($studentGroupDto);
    }

    public function get(array $request): array
    {
        $studentId = $request['student_id'] ?? null;
        $groupId = $request['group_id'] ?? null;

        if ($studentId) {
            return $this->studentGroupService->getGroupsList($studentId);
        }

        if ($groupId) {
            return $this->studentGroupService->getStudentsList($groupId);
        }

        return $this->studentGroupService->getFullInformation();
    }
}