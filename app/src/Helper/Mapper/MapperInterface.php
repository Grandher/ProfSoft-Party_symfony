<?php

namespace App\Helper\Mapper;

interface MapperInterface
{
    public function castEntityToDTO($entity);

    public function castEntityFromDTO($DTO, $entity = null);
}
