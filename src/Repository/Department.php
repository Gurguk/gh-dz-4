<?php

namespace Repository;

class Department
{
    public $id;

    public $name;

    public $university_id;

    public $university_name;

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getUniversityId()
    {
        return $this->university_id;
    }
    public function setUniversityId($university_id)
    {
        $this->university_id = $university_id;

        return $this;
    }

    public function getUniversityName()
    {
        return $this->university_name;
    }
}
