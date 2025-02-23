<?php

namespace task3\services;

use Doctrine\ORM\EntityManager;
use Dompdf\Dompdf;
use task3\dto\StudentDto;
use task3\entities\StudentEntity;
use Throwable;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;


class StudentService
{
    public EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param int $studentId
     * @return array
     */
    public function getStudentById(int $studentId): array
    {
        try {
            $student = $this->entityManager->getRepository(StudentEntity::class)->find($studentId);

            return [$student->getStudentEntityFromDto()];
        } catch (Throwable) {
            printError('Ошибка при получении студента');
        }
    }

    /**
     * @return array
     */
    public function getStudents(): array
    {
        try {
            $students = $this->entityManager->getRepository(StudentEntity::class)->findAll();

            $result = [];
            foreach ($students as $student) {
                $result[] = $student->getStudentEntityFromDto();
            }

            return $result;
        } catch (Throwable) {
            printError('Ошибка при получении студентов');
        }
    }

    /**
     * @param StudentDto $studentDto
     * @return void
     */
    public function create(StudentDto $studentDto): void
    {
        try {
            $student = new StudentEntity();

            $student->setStudentEntityToDto($studentDto);
            $this->entityManager->persist($student);
            $this->entityManager->flush();
        } catch (Throwable) {
            printError('Ошибка при создании студента');
        }
    }

    /**
     * @param StudentDto $studentDto
     * @return void
     */
    public function update(StudentDto $studentDto): void
    {
        try {
            $student = $this->entityManager->getRepository(StudentEntity::class)->find($studentDto->id);

            $student->setStudentEntityToDto($studentDto);
            $this->entityManager->persist($student);
            $this->entityManager->flush();
        } catch (Throwable) {
            printError('Ошибка при обновлении студента');
        }
    }

    /**
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        try {
            $student = $this->entityManager->getRepository(StudentEntity::class)->find($id);
            $this->entityManager->remove($student);
            $this->entityManager->flush();
        } catch (Throwable) {
            printError('Ошибка при удалении студента');
        }
    }

    /**
     * @return void
     */
    public function getPdf(): void
    {
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);

        $students = $this->entityManager->getRepository(StudentEntity::class)->findAll();
        $studentsPdf = [];

        foreach ($students as $student) {
            $studentsPdf[] = $student->getStudentEntityFromDto();
        }

        $html = $twig->render('studentsTable.html', ['students' => $studentsPdf]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('students.pdf');
    }
}