<?php
class UserDTO
{
    public function __construct(
        public $email,
        public $password
    ) {}
}