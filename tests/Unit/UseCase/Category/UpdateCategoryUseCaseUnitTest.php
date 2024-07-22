<?php 

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\UpdateCategoryUseCase;
use Core\UseCase\DTO\Category\UpdateCategory\CategoryUpdateInputDto;
use Core\UseCase\DTO\Category\UpdateCategory\CategoryUpdateOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class UpdateCategoryUseCaseUnitTest extends TestCase
{
    public function testRenameCategory()
    {
        $uuid = (string) Uuid::uuid4()->toString();
        $categoryName = 'Category Name';
        $categoryDescription = 'Description';

        $mockEntity = Mockery::mock(Category::class, [
            $uuid, $categoryName, $categoryDescription
        ]);
        $mockEntity->shouldReceive('update');
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $mockRepo->shouldReceive('findById')->andReturn($mockEntity);
        $mockRepo->shouldReceive('update')->andReturn($mockEntity);

        $mockInputDto = Mockery::mock(CategoryUpdateInputDto::class, [
            $uuid,
            'New category name',
        ]);


        $useCase = new UpdateCategoryUseCase($mockRepo);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(CategoryUpdateOutputDto::class, $response);

        $spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $spy->shouldReceive('findById')->andReturn($mockEntity);
        $spy->shouldReceive('update')->andReturn($mockEntity);
        $useCase = new UpdateCategoryUseCase($spy);
        $useCase->execute($mockInputDto);
        $spy->shouldHaveReceived('findById');
        $spy->shouldHaveReceived('update');

        Mockery::close();
    }
}