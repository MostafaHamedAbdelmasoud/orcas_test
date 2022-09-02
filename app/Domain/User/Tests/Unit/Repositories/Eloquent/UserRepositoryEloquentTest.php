<?php

namespace App\Domain\User\Tests\Unit\Repositories\Eloquent;

use Tests\TestCase;
use ReflectionClass;
use App\Domain\User\Entities\User;
use App\Domain\User\Repositories\Eloquent\UserRepositoryEloquent;

class UserRepositoryEloquentTest extends TestCase
{
    /** @test */
    public function it_should_implment_user_repository_interface()
    {
        $reflectedClass = new ReflectionClass($this->userRepository);
        $this->assertArrayHasKey("App\Domain\User\Repositories\Contracts\UserRepository", $reflectedClass->getInterfaces());
    }

    /** @test */
    public function it_should_return_user_model()
    {
        $this->assertEquals(User::class, $this->userRepository->model());
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->userRepository = app(UserRepositoryEloquent::class);
    }
}
