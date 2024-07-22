<?php 

namespace Tests\Unit\Domain\Validation;

use Core\Domain\Exception\EntityValidationException;
use Core\Domain\Validation\DomainValidation;
use PHPUnit\Framework\TestCase;
use Throwable;

class DomainValidationUnitTest extends TestCase
{
    public function testNotNull()
    {
        try {
            $value = '';
            DomainValidation::notNull($value);

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testNotNullCustomMessageException()
    {
        try {
            $value = '';
            DomainValidation::notNull($value, 'Custom message');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message');
        }
    }

    public function testStrMaxLength()
    {
        try {
            $value = 'Test';
            DomainValidation::strMaxLength($value, 3, 'Custom message');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message');
        }
    }

    public function testStrMinLength()
    {
        try {
            $value = 'Test';
            DomainValidation::strMinLength($value, 5, 'Custom message');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message');
        }
    }

    public function testStrCanNullAndMaxLength()
    {
        try {
            $value = 'Test';
            DomainValidation::strCanNullAndMaxLength($value, 3, 'Custom message');

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th, 'Custom message');
        }
    }
}