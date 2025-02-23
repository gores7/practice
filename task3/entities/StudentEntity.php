<?php

namespace task3\entities;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use task3\dto\StudentDto;

#[Entity]
#[Table(name: 'students')]
class StudentEntity
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[Column(name: 'last_name', type: Types::STRING)]
    private string $lastName;

    #[Column(name: 'first_name', type: Types::STRING)]
    private string $firstName;

    #[Column(name: 'patronymic', type: Types::STRING, nullable: true)]
    private ?string $patronymic = null;

    #[Column(name: 'email', type: Types::STRING, nullable: true)]
    private ?string $email = null;

    #[Column(name: 'birth', type: Types::STRING, nullable: true)]
    private ?string $dateOfBirth = null;

    #[OneToMany(targetEntity: StudentGroupEntity::class, mappedBy: 'studentId', orphanRemoval: true)]
    private Collection $studentGroup;

    public function __construct()
    {
        $this->studentGroup = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return StudentEntity
     */
    public function setLastName(string $lastName): StudentEntity
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return StudentEntity
     */
    public function setFirstName(string $firstName): StudentEntity
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    /**
     * @param string|null $patronymic
     * @return StudentEntity
     */
    public function setPatronymic(?string $patronymic): StudentEntity
    {
        $this->patronymic = $patronymic;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     * @return StudentEntity
     */
    public function setEmail(?string $email): StudentEntity
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    /**
     * @param string|null $dateOfBirth
     * @return StudentEntity
     */
    public function setDateOfBirth(?string $dateOfBirth): StudentEntity
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    /**
     * @return Collection
     */
    public function getStudentGroup(): Collection
    {
        return $this->studentGroup;
    }

    /**
     * @param StudentGroupEntity $studentGroup
     * @return StudentEntity
     */
    public function setStudentGroup(StudentGroupEntity $studentGroup): StudentEntity
    {
        $this->studentGroup->add($studentGroup);
        $studentGroup->setStudent($this);
        return $this;
    }

    /**
     * @param StudentGroupEntity $studentGroup
     * @return StudentEntity
     */
    public function removeStudentGroup(StudentGroupEntity $studentGroup): StudentEntity
    {
        $this->studentGroup = new ArrayCollection();
        return $this;
    }

    /**
     * @return StudentDto
     */
    public function getStudentEntityFromDto(): StudentDto
    {
        $studentDto = new StudentDto();
        $studentDto->id = $this->getId();
        $studentDto->lastName = $this->getLastName();
        $studentDto->firstName = $this->getFirstName();
        $studentDto->patronymic = $this->getPatronymic();
        $studentDto->email = $this->getEmail();
        $studentDto->dateOfBirth = $this->getDateOfBirth();

        return $studentDto;
    }

    /**
     * @param StudentDto $studentDto
     * @return void
     */
    public function setStudentEntityToDto(StudentDto $studentDto): void
    {
        $this->setLastName($studentDto->lastName);
        $this->setFirstName($studentDto->firstName);
        $this->setPatronymic($studentDto->patronymic);
        $this->setEmail($studentDto->email);
        $this->setDateOfBirth($studentDto->dateOfBirth);
    }
}