<?php

namespace task3\controllers;

use task3\dto\StudentDto;
use task3\services\StudentService;

class StudentController
{
    public StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    /**
     * Получение данных студента
     * @param array $request
     * @return array
     */
    public function get(array $request): array
    {
        $studentId = $request['id'];

        if ($studentId) {
            return $this->studentService->getStudentById($studentId);
        }

        return $this->studentService->getStudents();
    }

    /**
     * Добавление нового студента
     * @param array $request
     * @return void
     */
    public function create(array $request): void
    {
        $studentDto = new StudentDto();

        $this->setStudentAttributesToDto($studentDto, $request);
        $this->studentService->create($studentDto);
    }


    /**
     * Обновление данных студента
     * @param array $request
     * @return void
     */
    public function update(array $request): void
    {
        $studentDto = new StudentDTO();

        $studentDto->id = $request['id'];
        $this->setStudentAttributesToDto($studentDto, $request);
        $this->studentService->update($studentDto);
    }

    /**
     * Удаление данных студента
     * @param array $request
     * @return void
     */
    public function delete(array $request): void
    {
        $id = $request['id'];
        $this->studentService->delete($id);
    }

    /**
     * Получение информации о студентах в виде PDF-файла
     * @return void
     */
    public function getPdf(): void
    {
        $this->studentService->getPdf();
    }

    /**
     * Запись данных студента в Dto
     * @param StudentDto $studentDto
     * @param array $request
     * @return void
     */
    private function setStudentAttributesToDto(StudentDto $studentDto, array $request): void
    {
        $studentDto->lastName = $request['last_name'];
        $studentDto->firstName = $request['first_name'];
        $studentDto->patronymic = $request['patronymic'];
        $studentDto->email = $request['email'];
        $studentDto->dateOfBirth = $request['birth'];
    }
}