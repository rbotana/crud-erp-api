<?php 

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\CreateCategoryUseCase;
use Core\UseCase\DTO\Category\CreateCategory\CategoryCreateInputDto;
use Core\UseCase\DTO\Category\CreateCategory\CategoryCreateOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{    
    public function testCreateNewCategory()
    {
        $uuid  =(string) Uuid::uuid4()->toString();
        $categoryName = 'TestCategory';

        $mockEntity = Mockery::mock(Category::class, [
            $uuid,
            $categoryName,
        ]);
        $mockEntity->shouldReceive('id')->andReturn($uuid);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $mockRepo->shouldReceive('insert')->andReturn($mockEntity);

        $mockInputDto = Mockery::mock(CategoryCreateInputDto::class, [$categoryName]);

        $useCase = new CreateCategoryUseCase($mockRepo);
        $responseUseCase = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(CategoryCreateOutputDto::class, $responseUseCase);
        $this->assertEquals($categoryName, $responseUseCase->name);
        $this->assertEquals('', $responseUseCase->description);


        $spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $spy->shouldReceive('insert')->andReturn($mockEntity);
        $useCase = new CreateCategoryUseCase($spy);
        $responseUseCase = $useCase->execute($mockInputDto);
        $spy->shouldHaveReceived('insert');

        Mockery::close();
    }
}