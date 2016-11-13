<?php

namespace Repository;

class Student
{
    public $id;

    public $first_name;

    public $last_name;

    public $email;

    public $phone;

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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;

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
