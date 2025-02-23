<?php

namespace task3\controllers;

use task3\dto\GroupDto;
use task3\services\GroupService;

class GroupController
{
    public GroupService $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    /**
     * Получение данных группы
     * @param array $request
     * @return array
     */
    public function get(array $request): array
    {
        $groupId = $request['id'];

        if ($groupId) {
            return $this->groupService->getGroupById($groupId);
        }

        return $this->groupService->getGroups();
    }

    /**
     * Добавление новой группы
     * @param array $request
     * @return void
     */
    public function create(array $request): void
    {
        $groupDto = new GroupDto();

        $this->setGroupAttributesToDto($groupDto, $request);
        $this->groupService->create($groupDto);
    }

    /**
     * Обновление данных группы
     * @param array $request
     * @return void
     */
    public function update(array $request): void
    {
        $groupDto = new GroupDTO();

        $groupDto->id = $request['id'];
        $this->setGroupAttributesToDto($groupDto, $request);
        $this->groupService->update($groupDto);
    }

    /**
     * Удаление группы
     * @param array $request
     * @return void
     */
    public function delete(array $request): void
    {
        $id = $request['id'];
        $this->groupService->delete($id);
    }

    /**
     * Получение информации о группах в виде PDF-файла
     * @return void
     */
    public function getPdf(): void
    {
        $this->groupService->getPdf();
    }

    /**
     * Запись данных группы в Dto
     * @param GroupDto $groupDto
     * @param array $request
     * @return void
     */
    private function setGroupAttributesToDto(GroupDto $groupDto, array $request): void
    {
        $groupDto->groupName = $request['group_name'];
        $groupDto->groupType = $request['group_type'];
    }
}