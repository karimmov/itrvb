<?php

namespace Tgu\Karimov\Posts;

class User
{
    function __construct(private string $UUID, private string $username, private string $first_name, private string $last_name)
    {
        
    }

    function __toString()
    {
        return "$this->first_name $this->last_name";
    }

    public function getFirstName() : string
    {
        return $this->first_name;
    }

    public function getSecondName() : string
    {
        return $this->last_name;
    }

    public function getUUID():string
    {
        return $this->UUID;
    }

    public function getUsername() : string
    {
        return $this->username;
    }
}

?>