<?php

namespace Models;

interface ModelsInterface
{
    public function create(array $entityData);

    public function update(array $entityData);

    public function delete($id);

    public function findOne($id);

    public function findAll($limit, $offset);
}
