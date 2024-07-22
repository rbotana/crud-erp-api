<?php 

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\UseCase\Category\DeleteCategoryUseCase;
use Core\UseCase\DTO\Category\CategoryInputDto;
use Core\UseCase\DTO\Category\DeleteCategory\CategoryDeleteOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class DeleteCategoryUseCaseUnitTest extends TestCase
{
    public function testDelete()
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);        
        $mockRepo->shouldReceive('delete')->andReturn(true);

        $mockInputDto = Mockery::mock(CategoryInputDto::class, [$uuid]);

        $useCase = new DeleteCategoryUseCase($mockRepo);
        $responseUseCase = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(CategoryDeleteOutputDto::class, $responseUseCase);
        $this->assertTrue($responseUseCase->success);

        $spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $spy->shouldReceive('delete')->andReturn(true);
        $useCase = new DeleteCategoryUseCase($spy);
        $responseUseCase = $useCase->execute($mockInputDto);
        $spy->shouldHaveReceived('delete');
    }

    public function testDeleteFalse()
    {
        $uuid = (string) Uuid::uuid4()->toString();

        $mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);        
        $mockRepo->shouldReceive('delete')->andReturn(false);

        $mockInputDto = Mockery::mock(CategoryInputDto::class, [$uuid]);

        $useCase = new DeleteCategoryUseCase($mockRepo);
        $responseUseCase = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(CategoryDeleteOutputDto::class, $responseUseCase);
        $this->assertFalse($responseUseCase->success);        
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}