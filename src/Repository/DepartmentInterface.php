<?php

namespace Repository;

interface DepartmentInterface
{
    public function create(array $entityData);

    public function update(array $entityData);

    public function delete($id);

    public function findOne($id);

    public function findAll($limit, $offset);

    public function getName();

    public function setName($name);

    public function set();
}
