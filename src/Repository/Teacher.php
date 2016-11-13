<?php

namespace Repository;

class Teacher
{
    public $id;

    public $first_name;

    public $last_name;

    public $department_id;

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function setFirstName($first_name)
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function setLastName($last_name)
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getDepartmentId()
    {
        return $this->department_id;
    }

    public function setDepartmentId($department_id)
    {
        $this->department_id = $department_id;

        return $this;
    }
}
