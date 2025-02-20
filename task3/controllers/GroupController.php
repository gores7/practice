<?php

namespace task3\controllers;

use Doctrine\ORM\EntityManager;
use task3\dto\GroupDto;
use task3\services\GroupService;

class GroupController
{
    public GroupService $groupService;

    public function __construct(EntityManager $entityManager)
    {
        $this->groupService = new GroupService($entityManager);
    }

    public function get(array $request): array
    {
        $groupId = $request['id'] ?? null;

        return $this->groupService->get($groupId);
    }

    public function update(array $request): void
    {
        $groupDto = new GroupDTO();

        if (isset($request['id'])) {
            $groupDto->id = $request['id'];
        }

        $groupDto->groupName = $request['group_name'];
        $groupDto->groupType = $request['group_type'];

        $this->groupService->update($groupDto);
    }

    public function delete(array $request): void
    {
        $id = $request['id'];
        $this->groupService->delete($id);
    }

    public function getPdf(): void
    {
        $this->groupService->getPdf();
    }
}