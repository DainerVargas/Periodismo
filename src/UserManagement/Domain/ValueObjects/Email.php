<?php

declare(strict_types=1);

namespace Src\UserManagement\Domain\ValueObjects;

use InvalidArgumentException;
use Src\Shared\Domain\ValueObjects\ValueObject;

final class Email extends ValueObject
{
    private string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValidEmail($value);
        $this->value = $value;
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function ensureIsValidEmail(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the invalid email address: <%s>.', static::class, $value));
        }
    }
}
