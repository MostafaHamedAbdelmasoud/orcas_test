<?php

namespace App\Domain\User\Tests\Unit\Entities\Relations;

use Tests\TestCase;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Domain\User\Entities\Traits\Relations\UserRelations;

class UserRelationsTest extends TestCase
{
    

    public function setUp(): void
    {
        parent::setUp();
        $this->model = new class extends Model
        {use UserRelations;};
    }
}
