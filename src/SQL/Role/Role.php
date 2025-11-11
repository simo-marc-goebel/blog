<?php

namespace SimoMarcGoebel\Blog\SQL\Role;

class Role
{
    public int $id;
    public string $rolename;
    public function __construct(int $id, string $rolename)
    {
        $this->id = $id;
        $this->rolename = $rolename;
    }
}