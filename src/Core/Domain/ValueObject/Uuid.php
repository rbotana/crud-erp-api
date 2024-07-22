<?php 

namespace Core\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as UuidUuid;

class Uuid
{
    public function __construct(
        protected string $value
    ){

    }

    public static function random(): self
    {
        return new self(UuidUuid::uuid4()->toString());
    }

    public function __toString(): string
    {
        return $this->value;
    }

    private function isValid(string $id)
    {
        if(!Uuid::isValid($id)){
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>', static::class, $id));
        }
    }
}