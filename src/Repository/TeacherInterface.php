<?php

namespace Repository;

interface TeacherInterface
{
    public function create(array $entityData);

    public function update(array $entityData);

    public function delete($id);

    public function findOne($id);

    public function findAll($limit, $offset);

    public function getFirstName();

    public function setFirstName($first_name);

    public function getLastName();

    public function setLastName($last_name);

    public function getDepartmentId();

    public function setDepartmentId($id);

    public function set();
}
