<?php

namespace Tests\Unit;

use App\Models\Base\School;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Auth\Manager;
use App\Models\Auth\User;
use App\Repositories\Auth\ManagerRepository;

class ManagerTest extends TestCase
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
        factory(Manager::class, 5)->create();

        // Operations
        $repository = new ManagerRepository;
        $resp = $repository->all();

        // Control
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
    }

    public function test_get(){
        // Data preparation
        $model = factory(Manager::class)->create();

        // Operations
        $repository = new ManagerRepository;
        $resp = $repository->get($model->id);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Manager', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertEquals($model->user_id, $resp->getData()->user_id);
        $this->assertEquals($model->school_id, $resp->getData()->school_id);
        $this->assertEquals($model->identification_number, $resp->getData()->identification_number);
        $this->assertEquals($model->reference_code, $resp->getData()->reference_code);
    }

    public function test_get_by_reference_code(){
        // Data preparation
        $model = factory(Manager::class)->create();

        // Operations
        $repository = new ManagerRepository;
        $resp = $repository->getByReferenceCode($model->reference_code);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Manager', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertEquals($model->id, $resp->getData()->id);
    }

    public function test_create(){
        // Data preparation
        $user = factory(User::class)->create();
        $school = factory(School::class)->create();
        $data = [
            'user_id' => $user->id,
            'school_reference_code' => $school->manager_reference_code,
            'identification_number' => $this->faker->bothify('###########'),
        ];

        // Operations
        $repository = new ManagerRepository;
        $resp = $repository->create($data);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Manager', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertEquals($data['user_id'], $resp->getData()->user_id);
        $this->assertEquals($data['school_reference_code'], $resp->getData()->school->manager_reference_code);
        $this->assertEquals($data['identification_number'], $resp->getData()->identification_number);
        $this->assertNotNull($resp->getData()->user);
        $this->assertNotNull($resp->getData()->school);
    }

    public function test_update(){
        // Data preparation
        $model = factory(Manager::class)->create();
        $data = [
            'identification_number' => $this->faker->bothify('###########'),
        ];

        // Operations
        $repository = new ManagerRepository;
        $resp = $repository->update($model->id, $data);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Manager', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertFalse($resp->isDataNull());
        $this->assertNull($resp->getError());
        $this->assertEquals($data['identification_number'], $resp->getData()->identification_number);
    }

    public function test_delete(){
        // Data preparation
        $model = factory(Manager::class)->create();

        // Operations
        $repository = new ManagerRepository;
        $resp = $repository->delete($model->id);

        // Controls
        $this->assertNull($resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertTrue($resp->isDataNull());
        $this->assertNull(Manager::find($model->id));
        $this->assertNotNull(User::find($model->user_id));
        $this->assertNotNull(School::find($model->school_id));
    }

    public function test_set_active(){
        // Data preparation
        $model = factory(Manager::class)->create(['active' => false]);

        // Operations
        $repository = new ManagerRepository;
        $resp = $repository->setActive($model->id);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Manager', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertTrue($resp->getData()->active);
    }

    public function test_set_passive(){
        // Data preparation
        $model = factory(Manager::class)->create();

        // Operations
        $repository = new ManagerRepository;
        $resp = $repository->setPassive($model->id);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Manager', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertFalse($resp->getData()->active);
    }

    public function test_set_school(){
        // Data preparation
        $model = factory(Manager::class)->create();
        $school = factory(School::class)->create();

        // Operations
        $repository = new ManagerRepository;
        $resp = $repository->setSchool($model->id, $school->manager_reference_code);

        // Controls
        $this->assertInstanceOf('App\Models\Auth\Manager', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertEquals($school->id, $resp->getData()->school->id);
    }
}
