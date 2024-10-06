<?php

class Task
{
    public function __construct(
        public $id,
        public $title,
        public $description,
        public $category,
        public $time,
        public $tags,
        public $is_completed,
        public $is_editing,
        public $user_email
    ) {}
}