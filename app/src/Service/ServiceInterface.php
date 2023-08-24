<?php

namespace App\Service;

interface ServiceInterface
{
    public function getList(): array;

    public function delete($entityId): void;
}
