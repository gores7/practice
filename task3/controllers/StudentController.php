<?php

namespace task3\controllers;

use Doctrine\ORM\EntityManager;
use task3\dto\StudentDto;
use task3\services\StudentService;

class StudentController
{
    public StudentService $studentService;

    public function __construct(EntityManager $entityManager)
    {
        $this->studentService = new StudentService($entityManager);
    }

    public function get(array $request): array
    {
        $studentId = $request['id'] ?? null;

        return $this->studentService->get($studentId);
    }

    public function update(array $request): void
    {
        $studentDto = new StudentDTO();

        if (isset($request['id'])) {
            $studentDto->id = $request['id'];
        }

        $studentDto->lastName = $request['last_name'];
        $studentDto->firstName = $request['first_name'];
        $studentDto->patronymic = $request['patronymic'];
        $studentDto->email = $request['email'];
        $studentDto->dateOfBirth = $request['birth'];

        $this->studentService->update($studentDto);
    }

    public function delete(array $request): void
    {
        $id = $request['id'];
        $this->studentService->delete($id);
    }

    public function getPdf(): void
    {
        $this->studentService->getPdf();
    }
}