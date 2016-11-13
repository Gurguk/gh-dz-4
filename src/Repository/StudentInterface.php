<?php

namespace Repository;

interface StudentInterface
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

    public function getEmail();

    public function setEmail($email);

    public function getPhone();

    public function setPhone($phone);

    public function getDepartmentId();

    public function setDepartmentId($id);

    public function set();
}
