<?php 

namespace Tests\Unit\UseCase\Category;

use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Core\UseCase\Category\ListCategoriesUseCase;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesInputDto;
use Core\UseCase\DTO\Category\ListCategories\ListCategoriesOutputDto;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListCategoriesUseCaseUnitTest extends TestCase
{
    public function testListCategoriesEmpty()
    {
        $mockPagination = $this->mockPagination();

        $mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $mockRepo->shouldReceive('paginate')->andReturn($mockPagination);

        $mockInputDto = Mockery::mock(ListCategoriesInputDto::class, ['filter','desc']);

        $useCase = new ListCategoriesUseCase($mockRepo);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(ListCategoriesOutputDto::class, $response);
        $this->assertCount(0, $response->items);

        $spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $spy->shouldReceive('paginate')->andReturn($mockPagination);
        $useCase = new ListCategoriesUseCase($spy);
        $useCase->execute($mockInputDto);
        $spy->shouldHaveReceived('paginate');
        
    }

    public function testListCategories()
    {
        $register = new stdClass();
        $register->id = 'id';
        $register->name = 'name';
        $register->description = 'description';
        $register->is_active = 'is_active';
        $register->created_at = 'created_at';
        $register->updated_at = 'created_at';
        $register->deleted_at = 'created_at';


        $mockPagination = $this->mockPagination([$register]);

        $mockRepo = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $mockRepo->shouldReceive('paginate')->andReturn($mockPagination);

        $mockInputDto = Mockery::mock(ListCategoriesInputDto::class, ['filter','desc']);

        $useCase = new ListCategoriesUseCase($mockRepo);
        $response = $useCase->execute($mockInputDto);

        $this->assertInstanceOf(ListCategoriesOutputDto::class, $response);
        $this->assertInstanceOf(stdClass::class, $response->items[0]);
        $this->assertCount(1, $response->items);

        $spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $spy->shouldReceive('paginate')->andReturn($mockPagination);
        $useCase = new ListCategoriesUseCase($spy);
        $useCase->execute($mockInputDto);
        $spy->shouldHaveReceived('paginate');
        
    }

    protected function mockPagination(array $items = [])
    {
        $mockPagination = Mockery::mock(stdClass::class, PaginationInterface::class);
        $mockPagination->shouldReceive('items')->andReturn($items);
        $mockPagination->shouldReceive('total')->andReturn(0);
        $mockPagination->shouldReceive('currentPage')->andReturn(0);
        $mockPagination->shouldReceive('firstPage')->andReturn(0);
        $mockPagination->shouldReceive('lastPage')->andReturn(0);
        $mockPagination->shouldReceive('perPage')->andReturn(0);
        $mockPagination->shouldReceive('to')->andReturn(0);
        $mockPagination->shouldReceive('from')->andReturn(0);

        return $mockPagination;
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}