<?php
interface ValidationInterface {
    public function validate($data): bool;
}

class EmailValidator implements ValidationInterface {
    private $existingEmails;

    public function __construct(array $existingEmails) {
        $this->existingEmails = $existingEmails;
    }

    public function validate($data): bool {
        return filter_var($data, FILTER_VALIDATE_EMAIL) !== false
               && !in_array($data, $this->existingEmails);
    }
}

class PasswordValidator implements ValidationInterface {
    private $confirmPassword;

    public function __construct($confirmPassword) {
        $this->confirmPassword = $confirmPassword;
    }

    public function validate($data): bool {
        return $data === $this->confirmPassword;
    }
}

class Validator {
    private $type;
    private $data;
    private $validator;

    public function __construct(string $type, $data, $extra = null) {
        $this->type = $type;
        $this->data = $data;
        $this->validator = $this->getValidator($extra);
    }

    private function getValidator($extra): ValidationInterface {
        switch ($this->type) {
            case 'email':
                return new EmailValidator($extra);
            case 'password':
                return new PasswordValidator($extra);
            default:
                throw new Exception('Unknown validation type: ' . $this->type);
        }
    }

    public function validate(): bool {
        return $this->validator->validate($this->data);
    }
}