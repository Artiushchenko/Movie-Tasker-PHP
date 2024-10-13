<?php

class Task
{
    public function __construct(
        public $id,
        public $title,
        public $description,
        public $category,
        public $time,
        public $is_completed,
        public $user_email
    ) {}
}