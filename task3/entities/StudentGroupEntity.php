<?php

namespace task3\entities;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use task3\repository\StudentGroupRepository;

#[Entity(repositoryClass: StudentGroupRepository::class)]
#[Table(name: 'student_group')]
class StudentGroupEntity
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[ManyToOne(targetEntity: StudentEntity::class)]
    #[JoinColumn(name: 'student_id', referencedColumnName: 'id', nullable: false)]
    private StudentEntity $studentId;

    #[ManyToOne(targetEntity: GroupEntity::class)]
    #[JoinColumn(name: 'group_id', referencedColumnName: 'id', nullable: false)]
    private GroupEntity $groupId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return StudentEntity
     */
    public function getStudent(): StudentEntity
    {
        return $this->studentId;
    }

    /**
     * @param StudentEntity $studentId
     * @return StudentGroupEntity
     */
    public function setStudent(StudentEntity $studentId): StudentGroupEntity
    {
        $this->studentId = $studentId;
        return $this;
    }

    /**
     * @return GroupEntity
     */
    public function getGroup(): GroupEntity
    {
        return $this->groupId;
    }

    /**
     * @param GroupEntity $groupId
     * @return StudentGroupEntity
     */
    public function setGroup(GroupEntity $groupId): StudentGroupEntity
    {
        $this->groupId = $groupId;
        return $this;
    }
}