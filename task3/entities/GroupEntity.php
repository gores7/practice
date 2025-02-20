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
#[Table(name: 'groups')]
class GroupEntity
{
    #[Id]
    #[GeneratedValue(strategy: 'AUTO')]
    #[Column(name: 'id', type: Types::INTEGER)]
    private int $id;

    #[Column(name: 'group_name', type: Types::STRING, nullable: false)]
    private string $groupName;

    #[Column(name: 'group_type', type: Types::INTEGER, nullable: false)]
    private int $groupType;

    #[OneToMany(targetEntity: StudentGroupEntity::class, mappedBy: 'groupId', orphanRemoval: true)]
    private Collection $studentGroup;

    public function __construct()
    {
        $this->studentGroup = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getGroupName(): string
    {
        return $this->groupName;
    }

    public function setGroupName(string $groupName): GroupEntity
    {
        $this->groupName = $groupName;
        return $this;
    }

    public function getGroupType(): string
    {
        return $this->groupType;
    }

    public function setGroupType(string $groupType): GroupEntity
    {
        $this->groupType = $groupType;
        return $this;
    }

    public function getStudentGroup(): Collection
    {
        return $this->studentGroup;
    }

    public function setStudentGroup(StudentGroupEntity $studentGroup): GroupEntity
    {
        $this->studentGroup->add($studentGroup);
        $studentGroup->setGroup($this);
        return $this;
    }

    public function removeStudentGroup(StudentGroupEntity $studentGroup): GroupEntity
    {
        $this->studentGroup = new ArrayCollection();
        return $this;
    }
}