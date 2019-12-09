<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Auth\Guardian;
use App\Models\Auth\User;
use App\Repositories\Auth\GuardianRepository;

class GuardianTest extends TestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->artisan('migrate');
    }

    public function test_all()
    {
        // Data preparation
        factory(Guardian::class, 5)->create();

        // Operations
        $repository = new GuardianRepository;
        $resp = $repository->all();

        // Control
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
    }

    public function test_get(){
        // Data preparation
        $model = factory(Guardian::class)->create();

        // Operations
        $repository = new GuardianRepository;
        $resp = $repository->get($model->id);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Guardian', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertEquals($model->user_id, $resp->getData()->user_id);
        $this->assertEquals($model->reference_code, $resp->getData()->reference_code);
    }

    public function test_get_by_reference_code(){
        // Data preparation
        $model = factory(Guardian::class)->create();

        // Operations
        $repository = new GuardianRepository;
        $resp = $repository->getByReferenceCode($model->reference_code);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Guardian', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertEquals($model->id, $resp->getData()->id);
    }

    public function test_create(){
        // Data preparation
        $user = factory(User::class)->create();
        $data = [
            'user_id' => $user->id,
        ];

        // Operations
        $repository = new GuardianRepository;
        $resp = $repository->create($data);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Guardian', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertEquals($data['user_id'], $resp->getData()->user_id);
        $this->assertNotNull($resp->getData()->user);
    }

    public function test_update(){
        // Data preparation
        $model = factory(Guardian::class)->create();
        $data = [

        ];

        // Operations
        $repository = new GuardianRepository;
        $resp = $repository->update($model->id, $data);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Guardian', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertFalse($resp->isDataNull());
        $this->assertNull($resp->getError());
    }

    public function test_delete(){
        // Data preparation
        $model = factory(Guardian::class)->create();

        // Operations
        $repository = new GuardianRepository;
        $resp = $repository->delete($model->id);

        // Controls
        $this->assertNull($resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertTrue($resp->isDataNull());
        $this->assertNull(Guardian::find($model->id));
        $this->assertNotNull(User::find($model->user_id));
    }

    public function test_set_active(){
        // Data preparation
        $model = factory(Guardian::class)->create(['active' => false]);

        // Operations
        $repository = new GuardianRepository;
        $resp = $repository->setActive($model->id);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Guardian', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertTrue($resp->getData()->active);
    }

    public function test_set_passive(){
        // Data preparation
        $model = factory(Guardian::class)->create();

        // Operations
        $repository = new GuardianRepository;
        $resp = $repository->setPassive($model->id);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Guardian', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertFalse($resp->getData()->active);
    }
}
