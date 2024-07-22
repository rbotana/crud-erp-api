<?php

namespace Tests\Unit\Domain\Entity;

use Core\Domain\Entity\Category;
use Core\Domain\Exception\EntityValidationException;
use Core\Domain\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid as UuidUuid;
use Throwable;

class CategoryUnitTest extends TestCase
{
    public function testAttributes()
    {
        $category = new Category(            
            name: 'New Category',
            description: 'This is a new category',
            isActive: true
        );

        $this->assertNotEmpty($category->createdAt());
        $this->assertNotEmpty($category->id());
        $this->assertEquals('New Category', $category->name);
        $this->assertEquals('This is a new category', $category->description);
        $this->assertEquals(true, $category->isActive);
    }

    public function testActivated()
    {
        $category = new Category(
            name: 'New Category',
            isActive: false,
        );

        $this->assertFalse($category->isActive);
        $category->activate();
        $this->assertTrue($category->isActive);
    }

    public function testDeactivated()
    {
        $category = new Category(
            name: 'New Category',
            isActive: true,
        );

        $this->assertTrue($category->isActive);
        $category->deactivate();
        $this->assertFalse($category->isActive);
    }

    public function testUpdate()
    {
        $uuid = UuidUuid::uuid4()->toString();

        $category = new Category(
            id: $uuid,
            name: 'New Category',
            description: 'This is a new category',
            isActive: true,
            createdAt: '2024-01-01 10:00:00'
        );

        $category->update(
            name: 'Updated Category',
            description: 'This is an updated category'
        );

        $this->assertEquals('Updated Category', $category->name);
        $this->assertEquals('This is an updated category', $category->description);
        $this->assertEquals($uuid, $category->id);
        #$this->assertTrue($category->isActive);
    }

    public function testExceptionName()
    {
        try {
            new Category(
                name: 'Na',
                description: 'This is a new category'                
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    public function testExceptionDescription()
    {
        try {
            new Category(
                name: 'Category name',
                description: random_bytes(9999)                
            );

            $this->assertTrue(false);
        } catch (Throwable $th) {
            $this->assertInstanceOf(EntityValidationException::class, $th);
        }
    }

    
}
