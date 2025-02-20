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

    public function get(?int $studentId): array
    {
        if ($studentId) {
            try {
                $student = $this->entityManager->getRepository(StudentEntity::class)->find($studentId);

                return [$this->mapStudentEntityToDto($student)];
            } catch (Throwable) {
                printError('Ошибка при получении студента');
                return [];
            }
        } else {
            $students = $this->entityManager->getRepository(StudentEntity::class)->findAll();

            $result = [];
            foreach ($students as $student) {
                $result[] = $this->mapStudentEntityToDto($student);
            }

            return $result;
        }
    }

    public function update(StudentDto $studentDto): void
    {
        if (isset($studentDto->id)) {
            $student = $this->entityManager->getRepository(StudentEntity::class)->find($studentDto->id);
        } else {
            $student = new StudentEntity();
        }

        try {
            $student->setLastName($studentDto->lastName);
            $student->setFirstName($studentDto->firstName);
            $student->setPatronymic($studentDto->patronymic);
            $student->setEmail($studentDto->email);
            $student->setDateOfBirth($studentDto->dateOfBirth);

            $this->entityManager->persist($student);
            $this->entityManager->flush();
        } catch (Throwable) {
            printError('Ошибка при обновлении/создании студента');
        }
    }

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

    public function getPdf(): void
    {
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);

        $students = $this->entityManager->getRepository(StudentEntity::class)->findAll();
        $studentsPdf = [];

        foreach ($students as $student) {
            $studentsPdf[] = $this->mapStudentEntityToDto($student);
        }

        $html = $twig->render('studentsTable.html', ['students' => $studentsPdf]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }

    private function mapStudentEntityToDto(StudentEntity $student): StudentDto
    {
        $studentDto = new StudentDto();
        $studentDto->id = $student->getId();
        $studentDto->lastName = $student->getLastName();
        $studentDto->firstName = $student->getFirstName();
        $studentDto->patronymic = $student->getPatronymic();
        $studentDto->email = $student->getEmail();
        $studentDto->dateOfBirth = $student->getDateOfBirth();

        return $studentDto;
    }
}