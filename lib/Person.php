<?php
class Person
{
    protected $id;
    protected $name;

    public function __construct(array $data) 
    {
        $this->id = $data['id'];
        $this->name = $data['name'];
    }
}

