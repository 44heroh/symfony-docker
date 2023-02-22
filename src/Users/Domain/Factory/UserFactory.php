<?php


namespace App\Users\Domain\Factory;

use App\Users\Domain\Entity\User;
use App\Users\Domain\Service\UserPasswordHasherInterface;

class UserFactory
{

    public function create(string $email, string $password): User
    {
        return new User($email, $password);
    }
}