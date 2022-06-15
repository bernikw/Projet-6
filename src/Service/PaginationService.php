<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class PaginationService
{

    private mixed $data;
    private int $page;
    private int $maxPage;

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function createPagination(string $repositoryName, array $criteria, array $orderBy, int $page, int $maxItemParPage)
    {
        $limit = $maxItemParPage * $page;
        $this->page = $page;
        $repository = $this->entityManager->getRepository($repositoryName);

        $count = $repository->count($criteria); 
        $this->maxPage = ceil($count/$maxItemParPage);

        $this->data = $repository->findBy($criteria, $orderBy, $limit, 0);
    }

    public function getData(): mixed
    {
        return $this->data;
    }

    public function nextPage(): ?int
    {
        $nextPage = $this->page + 1;
        
        if($nextPage > $this->page + 1){
            $nextPage = null;
        }
        return $nextPage;
    }
}
