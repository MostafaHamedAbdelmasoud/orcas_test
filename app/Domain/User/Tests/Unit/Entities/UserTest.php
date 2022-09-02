<?php

namespace App\Domain\User\Tests\Unit\Entities;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use ReflectionClass;
use App\Domain\User\Entities\User;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function it_can_display_list_of_customers()
    {
        $user = User::factory()->create();

        $response = $this->json('get', 'api/users/index');

        $response->assertSuccessful();

        $response->assertSee(e($user->firstName));
    }

    /** @test */
    public function it_should_has_fillable()
    {
        $this->assertEquals(["firstName", "lastName", "email", "avatar", "password", "activation_token", "email_verified_at"], $this->user->getFillable());
    }

    /** @test */
    public function it_should_has_hidden()
    {
        $this->assertEquals(["password", "remember_token", "activation_token"], $this->user->getHidden());
    }

    /** @test */
    public function it_should_has_Users_table()
    {
        $this->assertEquals("users", $this->user->getTable());
    }

    /** @test */
    public function it_should_casts_email_verified_at_to_datetime()
    {
        $this->assertEquals("datetime", $this->user->getCasts()["email_verified_at"]);
    }

    /** @test */
    public function it_should_log_attributes_with_name_of_user()
    {
        $class = new ReflectionClass($this->user);
        $logName = $class->getProperty("logName");
        $logName->setAccessible(true);
        $this->assertEquals("User", $logName->getValue($this->user));
    }

    /** @test */
    public function it_should_log_all_attributes_of_user()
    {
        $class = new ReflectionClass($this->user);
        $logAttributes = $class->getProperty("logAttributes");
        $logAttributes->setAccessible(true);
        $this->assertEquals(["*"], $logAttributes->getValue());
    }

    /** @test */
    public function it_should_has_hasapitokens_trait()
    {
        $user = new ReflectionClass($this->user);
        $this->assertArrayHasKey("Laravel\Passport\HasApiTokens", $user->getTraits());
    }

    /** @test */
    public function it_should_has_notifiable_trait()
    {
        $user = new ReflectionClass($this->user);
        $this->assertArrayHasKey("Illuminate\Notifications\Notifiable", $user->getTraits());
    }

    /** @test */
    public function it_should_has_userrelations_trait()
    {
        $user = new ReflectionClass($this->user);
        $this->assertArrayHasKey("App\Domain\User\Entities\Traits\Relations\UserRelations", $user->getTraits());
    }

    /** @test */
    public function it_should_has_userattributes_trait()
    {
        $user = new ReflectionClass($this->user);
        $this->assertArrayHasKey("App\Domain\User\Entities\Traits\CustomAttributes\UserAttributes", $user->getTraits());
    }

    /** @test */
    public function it_should_has_hasfactory_trait()
    {
        $user = new ReflectionClass($this->user);
        $this->assertArrayHasKey("Illuminate\Database\Eloquent\Factories\HasFactory", $user->getTraits());
    }


    public function setUp(): void
    {
        parent::setUp();
        $this->user = app(User::class);
    }

}
