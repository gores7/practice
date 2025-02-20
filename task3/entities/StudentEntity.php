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

    public function getId(): int
    {
        return $this->id;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): StudentEntity
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): StudentEntity
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    public function setPatronymic(?string $patronymic): StudentEntity
    {
        $this->patronymic = $patronymic;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): StudentEntity
    {
        $this->email = $email;
        return $this;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?string $dateOfBirth): StudentEntity
    {
        $this->dateOfBirth = $dateOfBirth;
        return $this;
    }

    public function getStudentGroup(): Collection
    {
        return $this->studentGroup;
    }

    public function setStudentGroup(StudentGroupEntity $studentGroup): StudentEntity
    {
        $this->studentGroup->add($studentGroup);
        $studentGroup->setStudent($this);
        return $this;
    }

    public function removeStudentGroup(StudentGroupEntity $studentGroup): StudentEntity
    {
        $this->studentGroup = new ArrayCollection();
        return $this;
    }
}