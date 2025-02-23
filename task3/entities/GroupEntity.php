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
use task3\dto\GroupDto;

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
    public function getGroupName(): string
    {
        return $this->groupName;
    }

    /**
     * @param string $groupName
     * @return GroupEntity
     */
    public function setGroupName(string $groupName): GroupEntity
    {
        $this->groupName = $groupName;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupType(): string
    {
        return $this->groupType;
    }

    /**
     * @param string $groupType
     * @return GroupEntity
     */
    public function setGroupType(string $groupType): GroupEntity
    {
        $this->groupType = $groupType;
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
     * @return GroupEntity
     */
    public function setStudentGroup(StudentGroupEntity $studentGroup): GroupEntity
    {
        $this->studentGroup->add($studentGroup);
        $studentGroup->setGroup($this);
        return $this;
    }

    /**
     * @param StudentGroupEntity $studentGroup
     * @return GroupEntity
     */
    public function removeStudentGroup(StudentGroupEntity $studentGroup): GroupEntity
    {
        $this->studentGroup = new ArrayCollection();
        return $this;
    }

    /**
     * @return GroupDto
     */
    public function getGroupEntityFromDto(): GroupDto
    {
        $groupDto = new GroupDto();
        $groupDto->id = $this->getId();
        $groupDto->groupName = $this->getGroupName();
        $groupDto->groupType = $this->getGroupType();

        return $groupDto;
    }

    /**
     * @param GroupDto $groupDto
     * @return void
     */
    public function setGroupEntityToDto(GroupDto $groupDto): void
    {
        $this->setGroupName($groupDto->groupName);
        $this->setGroupType($groupDto->groupType);
    }
}