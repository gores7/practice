<?php

namespace task3\services;

use Doctrine\ORM\EntityManager;
use Dompdf\Dompdf;
use task3\dto\GroupDto;
use task3\entities\GroupEntity;
use Throwable;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class GroupService
{
    public EntityManager $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function get(?int $groupId): array
    {
        if ($groupId) {
            try {
                $group = $this->entityManager->getRepository(GroupEntity::class)->find($groupId);

                return [$this->mapGroupEntityToDto($group)];
            } catch (Throwable) {
                printError('Ошибка при получении группы');
                return [];
            }
        } else {
            $groups = $this->entityManager->getRepository(GroupEntity::class)->findAll();

            $result = [];
            foreach ($groups as $group) {
                $result[] = $this->mapGroupEntityToDto($group);
            }

            return $result;
        }
    }

    public function update(GroupDto $groupDto): void
    {
        if (isset($groupDto->id)) {
            $group = $this->entityManager->getRepository(GroupEntity::class)->find($groupDto->id);
        } else {
            $group = new GroupEntity();
        }

        try {
            $group->setGroupName($groupDto->groupName);
            $group->setGroupType($groupDto->groupType);

            $this->entityManager->persist($group);
            $this->entityManager->flush();
        } catch (Throwable) {
            printError('Ошибка при обновлении/создании группы');
        }
    }

    public function delete(int $id): void
    {
        try {
            $group = $this->entityManager->getRepository(GroupEntity::class)->find($id);
            $this->entityManager->remove($group);
            $this->entityManager->flush();
        } catch (Throwable) {
            printError('Ошибка при удалении группы');
        }
    }

    public function getPdf(): void
    {
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);

        $groups = $this->entityManager->getRepository(GroupEntity::class)->findAll();
        $groupsPdf = [];

        foreach ($groups as $group) {
            $groupsPdf[] = $this->mapGroupEntityToDto($group);
        }

        $html = $twig->render('groupsTable.html', ['groups' => $groupsPdf]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream();
    }

    private function mapGroupEntityToDto(GroupEntity $group): GroupDto
    {
        $groupDto = new GroupDto();
        $groupDto->id = $group->getId();
        $groupDto->groupName = $group->getGroupName();
        $groupDto->groupType = $group->getGroupType();

        return $groupDto;
    }
}
