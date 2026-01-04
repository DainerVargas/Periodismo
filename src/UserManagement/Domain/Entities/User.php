<?php

declare(strict_types=1);

namespace Src\UserManagement\Domain\Entities;

use Src\UserManagement\Domain\ValueObjects\Email;
use Src\UserManagement\Domain\ValueObjects\UserRole;

final class User
{
    public function __construct(
        private ?int $id,
        private string $name,
        private Email $email,
        private string $password,
        private UserRole $role,
        private bool $isActive,
        private ?string $avatar = null,
        private ?string $bio = null
    ) {}

    public static function create(
        string $name,
        Email $email,
        string $password,
        UserRole $role
    ): self {
        return new self(
            null,
            $name,
            $email,
            $password,
            $role,
            true
        );
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function role(): UserRole
    {
        return $this->role;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function avatar(): ?string
    {
        return $this->avatar;
    }

    public function bio(): ?string
    {
        return $this->bio;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email->value(),
            'role' => $this->role->value(),
            'is_active' => $this->isActive,
            'avatar' => $this->avatar,
            'bio' => $this->bio,
        ];
    }
}
