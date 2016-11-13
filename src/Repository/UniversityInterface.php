<?php

namespace Repository;

interface UniversityInterface
{
    public function create(array $entityData);

    public function update(array $entityData);

    public function delete($id);

    public function findOne($id);

    public function findAll($limit, $offset);

    public function getName();

    public function setName($name);

    public function getCity();

    public function setCity($city);

    public function getSite();

    public function setSite($phone);

    public function set();
}
