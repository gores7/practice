<?php

namespace task3\controllers;

use task3\dto\StudentGroupDto;
use task3\services\StudentGroupService;

class StudentGroupController
{
    public StudentGroupService $studentGroupService;

    public function __construct(StudentGroupService $studentGroupService)
    {
        $this->studentGroupService = $studentGroupService;
    }

    /**
     * Связь студента и группы
     * @param array $request
     * @return void
     */
    public function create(array $request): void
    {
        $studentGroupDto = new StudentGroupDto();

        $studentGroupDto->studentId = $request['student_id'];
        $studentGroupDto->groupId = $request['group_id'];

        $this->studentGroupService->create($studentGroupDto);
    }

    /**
     * Получение списка групп для определённого студента
     * @param array $request
     * @return array
     */
    public function getGroupsList(array $request): array
    {
        $studentId = $request['student_id'];
        return $this->studentGroupService->getGroupsList($studentId);
    }

    /**
     * Получение списка студентов для определённой группы
     * @param array $request
     * @return array
     */
    public function getStudentsList(array $request): array
    {
        $groupId = $request['group_id'];
        return $this->studentGroupService->getStudentsList($groupId);
    }

    /**
     * Получение всей информации
     * @return array
     */
    public function getFullInformation(): array
    {
        return $this->studentGroupService->getFullInformation();
    }
}