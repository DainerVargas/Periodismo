<?php

declare(strict_types=1);

namespace Src\Shared\Domain\ValueObjects;

use JsonSerializable;

abstract class ValueObject implements JsonSerializable
{
    public function jsonSerialize(): mixed
    {
        return (string) $this;
    }

    abstract public function __toString(): string;

    public function equals(ValueObject $other): bool
    {
        return $this->__toString() === $other->__toString() && static::class === get_class($other);
    }
}
