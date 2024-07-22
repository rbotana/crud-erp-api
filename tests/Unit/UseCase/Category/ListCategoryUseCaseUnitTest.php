<?php

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\ListCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\CategoryOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListCategoryUseCaseUnitTest extends TestCase
{
    public function testGetById()
    {
        $id  = (string) Uuid::uuid4()->toString();
        $categoryName = 'TestCategory';

        $mockEntity = Mockery::mock(Category::class, [
            $id,
            $categoryName,
        ]);
        $mockEntity->shouldReceive('id')->andReturn($id);
        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $mockRepo->shouldReceive('findById')
            ->with($id)
            ->andReturn($mockEntity);

        $mockInputDto = Mockery::mock(CategoryInputDto::class, [
            $id,
        ]);

        $useCase = new ListCategoryUseCase($mockRepo);
        $response = $useCase->execute($mockInputDto);

        $this->isInstanceOf(CategoryOutputDto::class, $response);
        $this->assertEquals($categoryName, $response->name);
        $this->assertEquals($id, $response->id);


        $spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $spy->shouldReceive('findById')
            ->with($id)
            ->andReturn($mockEntity);

        $useCase = new ListCategoryUseCase($spy);
        $response = $useCase->execute($mockInputDto);
        $spy->shouldHaveReceived('findById');
    }


    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
