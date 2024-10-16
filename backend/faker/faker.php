<?php
require_once 'vendor/autoload.php';


abstract class FakerSetup
{
    protected $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create();
    }

    abstract public function generateData();
}

class UsersFaker extends FakerSetup
{
    private $passwordLength;

    public function __construct($passwordLength)
    {
        parent::__construct();
        $this->passwordLength = $passwordLength;
    }

    public function generatePassword()
    {
        return substr(str_shuffle(str_repeat(
            '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            ceil($this->passwordLength / 62)
        )), 1, $this->passwordLength);
    }

    public function generateData()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'password' => password_hash($this->generatePassword(), PASSWORD_DEFAULT)
        ];
    }
}

class TasksFaker extends FakerSetup
{
    private $userEmail;

    public function __construct($userEmail)
    {
        parent::__construct();
        $this->userEmail = $userEmail;
    }

    public function generateData()
    {
        return [
            'category' => $this->faker->randomElement(['Film', 'Serial']),
            'is_completed' => $this->faker->boolean() ? 1 : 0,
            'description' => $this->faker->text(80),
            'time' => $this->faker->numberBetween(60, 1000),
            'title' => $this->faker->sentence(3),
            'user_email' => $this->faker->randomElement($this->userEmail),
        ];
    }
}