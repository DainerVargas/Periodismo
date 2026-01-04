<?php

declare(strict_types=1);

namespace Src\UserManagement\Domain\ValueObjects;

use InvalidArgumentException;
use Src\Shared\Domain\ValueObjects\ValueObject;

final class UserRole extends ValueObject
{
    public const ADMIN = 'admin';
    public const EDITOR = 'editor';
    public const USER = 'user';

    private string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidRole($value);
        $this->value = $value;
    }

    public static function admin(): self
    {
        return new self(self::ADMIN);
    }

    public static function editor(): self
    {
        return new self(self::EDITOR);
    }

    public static function user(): self
    {
        return new self(self::USER);
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function isAdmin(): bool
    {
        return $this->value === self::ADMIN;
    }

    public function isEditor(): bool
    {
        return $this->value === self::EDITOR;
    }

    private function ensureIsValidRole(string $value): void
    {
        if (!in_array($value, [self::ADMIN, self::EDITOR, self::USER])) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the invalid role: <%s>.', static::class, $value));
        }
    }
}
