<?php
class Tag {
    public function __construct(
        public $id,
        public $title,
        public $is_used,
        public $user_email
    ) {}
}