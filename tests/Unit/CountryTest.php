<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Base\Country;
use App\Repositories\Base\CountryRepository;

class CountryTest extends TestCase
{
    use WithFaker;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->artisan('migrate');
    }

    public function test_all(){
        // Data preparation
        factory(Country::class, 5)->create();

        // Operations
        $repository = new CountryRepository;
        $resp = $repository->all();

        // Control
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
    }

    public function test_get(){
        // Data preparation
        $model = factory(Country::class)->create();

        // Operations
        $repository = new CountryRepository;
        $resp = $repository->get($model->id);

        // Control
        $this->assertInstanceOf('App\Models\Base\Country', $resp->getData());
        $this->assertEquals($model->code, $resp->getData()->code);
        $this->assertEquals($model->name, $resp->getData()->name);
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
    }

    public function test_create(){
        // Data preparation
        $data = [
            'code' => $this->faker->countryCode,
            'name' => $this->faker->country,
        ];

        // Operations
        $repository = new CountryRepository;
        $resp = $repository->create($data);

        // Control
        $this->assertInstanceOf('App\Models\Base\Country', $resp->getData());
        $this->assertEquals($data['code'], $resp->getData()->code);
        $this->assertEquals($data['name'], $resp->getData()->name);
        //$this->assertTrue($resp->getData()->active);
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
    }

    public function test_update(){
        // Data preparation
        $model = factory(Country::class)->create();
        $data = [
            'code' => $this->faker->countryCode,
            'name' => $this->faker->country,
        ];

        // Operations
        $repository = new CountryRepository;
        $resp = $repository->update($model->id, $data);

        // Control
        $this->assertInstanceOf('App\Models\Base\Country', $resp->getData());
        $this->assertEquals($data['code'], $resp->getData()->code);
        $this->assertEquals($data['name'], $resp->getData()->name);
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
    }

    public function test_delete(){
        // Data preparation
        $model = factory(Country::class)->create();

        // Operations
        $repository = new CountryRepository;
        $resp = $repository->delete($model->id);

        // Control
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getData());
        $this->assertNull($resp->getError());
        $this->assertNull(Country::find($model->id));
    }

    public function test_set_active(){
        // Data preparation
        $model = factory(Country::class)->create(['active' => false]);

        // Operations
        $repository = new CountryRepository;
        $resp = $repository->setActive($model->id);

        // Control
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertTrue($resp->getData()->active);
    }

    public function test_set_passive(){
        // Data preparation
        $model = factory(Country::class)->create();

        // Operations
        $repository = new CountryRepository;
        $resp = $repository->setPassive($model->id);

        // Control
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->getData()->active);
    }
}
