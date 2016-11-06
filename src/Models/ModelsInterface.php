<?php

namespace Models;


interface ModelsInterface
{
    public function init();

    public function create(array $entityData);

    public function update(array $entityData);

    public function remove($id);

    public function findOne($id);

    public function findAll($limit, $offset);
}