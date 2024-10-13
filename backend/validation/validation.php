<?php
interface ValidationInterface
{
    public function validate($data): bool;
}

class EmailValidator implements ValidationInterface
{
    public function validate($data): bool
    {
        return filter_var($data, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function isUnique($data, $connection): bool
    {
        $stmt = $connection->prepare('
            SELECT 
                COUNT(*) as count 
            FROM `users` 
            WHERE `users`.`email` = ?
        ');
        $stmt->bind_param("s", $data);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->fetch_assoc()['count'];

        return $count === 0;
    }
}

class PasswordValidator implements ValidationInterface
{
    public function validate($data): bool
    {
        return strlen($data) >= 6;
    }

    public function confirm($password, $confirmPassword): bool
    {
        return $password === $confirmPassword;
    }
}

class Validator
{
    private $validator;
    private $type;

    public function __construct($type) {
        $this->type = $type;
        $this->validator = $this->getValidator($type);
    }

    private function getValidator($type)
    {
        switch ($type) {
            case 'email':
                return new EmailValidator();
            case 'password':
                return new PasswordValidator();
            default:
                throw new Exception("Unknown validator type: $type");
        }
    }

    public function validate($data, $connection = null): bool
    {
        if(!$this->validator->validate($data)) {
            $_SESSION['errors'][$this->type] = "The {$this->type} field is filled incorrectly";
            return false;
        }

        return true;
    }
}