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

    /**
     * @param int $groupId
     * @return array
     */
    public function getGroupById(int $groupId): array
    {
        try {
            $group = $this->entityManager->getRepository(GroupEntity::class)->find($groupId);

            return [$group->getGroupEntityFromDto()];
        } catch (Throwable) {
            printError('Ошибка при получении группы');
        }
    }

    /**
     * @return array
     */
    public function getGroups(): array
    {
        try {
            $groups = $this->entityManager->getRepository(GroupEntity::class)->findAll();

            $result = [];
            foreach ($groups as $group) {
                $result[] = $group->getGroupEntityFromDto();
            }

            return $result;
        } catch (Throwable) {
            printError('Ошибка при получении групп');
        }
    }

    /**
     * @param GroupDto $groupDto
     * @return void
     */
    public function create(GroupDto $groupDto): void
    {
        try {
            $group = new GroupEntity();

            $group->setGroupEntityToDto($groupDto);
            $this->entityManager->persist($group);
            $this->entityManager->flush();
        } catch (Throwable) {
            printError('Ошибка при создании группы');
        }
    }

    /**
     * @param GroupDto $groupDto
     * @return void
     */
    public function update(GroupDto $groupDto): void
    {
        try {
            $group = $this->entityManager->getRepository(GroupEntity::class)->find($groupDto->id);

            $group->setGroupEntityToDto($groupDto);
            $this->entityManager->persist($group);
            $this->entityManager->flush();
        } catch (Throwable) {
            printError('Ошибка при обновлении/создании группы');
        }
    }

    /**
     * @param int $id
     * @return void
     */
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

    /**
     * @return void
     */
    public function getPdf(): void
    {
        $loader = new FilesystemLoader('templates');
        $twig = new Environment($loader);

        $groups = $this->entityManager->getRepository(GroupEntity::class)->findAll();
        $groupsPdf = [];

        foreach ($groups as $group) {
            $groupsPdf[] = $group->getGroupEntityFromDto();
        }

        $html = $twig->render('groupsTable.html', ['groups' => $groupsPdf]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('groups.pdf');
    }
}
