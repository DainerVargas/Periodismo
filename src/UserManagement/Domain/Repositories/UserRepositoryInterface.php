<?php

declare(strict_types=1);

namespace Src\UserManagement\Domain\Repositories;

use Src\UserManagement\Domain\Entities\User;
use Src\UserManagement\Domain\ValueObjects\Email;

interface UserRepositoryInterface
{
    public function find(int $id): ?User;
    public function findByEmail(Email $email): ?User;
    public function save(User $user): void;
    public function delete(int $id): void;
}
