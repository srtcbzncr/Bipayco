<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use App\Models\Auth\User;
use App\Models\Auth\Student;
use App\Models\Auth\Instructor;
use App\Models\Auth\Manager;
use App\Models\Auth\Admin;
use App\Models\Auth\Guardian;
use App\Models\Base\District;
use App\Repositories\Auth\UserRepository;

class UserTest extends TestCase
{
    use WithFaker;

    public function test_all(){
        // Data preparation
        factory(User::class, 5)->create();

        // Operations
        $repository = new UserRepository;
        $resp = $repository->all();

        // Control
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
    }

    public function test_get(){
        // Data preparation
        $model = factory(User::class)->create();

        // Operations
        $repository = new UserRepository;
        $resp = $repository->get($model->id);

        // Control
        $this->assertInstanceOf('App\Models\Auth\User', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertTrue($resp->getData()->active);
        Storage::assertExists($resp->getData()->avatar);
        $this->assertEquals($model->district_id, $resp->getData()->district_id);
        $this->assertEquals($model->student_id, $resp->getData()->student_id);
        $this->assertEquals($model->admin_id, $resp->getData()->admin_id);
        $this->assertEquals($model->instructor_id, $resp->getData()->instructor_id);
        $this->assertEquals($model->manager_id, $resp->getData()->manager_id);
        $this->assertEquals($model->guardian_id, $resp->getData()->guardian_id);
        $this->assertEquals($model->first_name, $resp->getData()->first_name);
        $this->assertEquals($model->last_name, $resp->getData()->last_name);
        $this->assertEquals($model->username, $resp->getData()->username);
        $this->assertEquals($model->email, $resp->getData()->email);
        $this->assertEquals($model->phone_number, $resp->getData()->phone_number);
        $this->assertEquals($model->password, $resp->getData()->password);
        $this->assertEquals($model->avatar, $resp->getData()->avatar);
    }

    public function test_create(){
        // Data preparation
        $file = UploadedFile::fake()->image('user.jpg');
        $district = factory(District::class)->create();
        $data = [
            'district_id' =>  $district->id,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'username' => $this->faker->userName,
            'email' => $this->faker->email,
            'phone_number' => $this->faker->e164PhoneNumber,
            'password' => '123456',
            'avatar' => $file,
        ];

        // Operations
        $repository = new UserRepository;
        $resp = $repository->create($data);

        //Control
        $this->assertInstanceOf('App\Models\Auth\User', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertFalse($resp->isDataNull());
        $this->assertNull($resp->getError());
        $this->assertEquals($data['district_id'], $resp->getData()->district_id);
        $this->assertNotNull($resp->getData()->student_id);
        $this->assertEquals($data['first_name'], $resp->getData()->first_name);
        $this->assertEquals($data['last_name'], $resp->getData()->last_name);
        $this->assertEquals($data['username'], $resp->getData()->username);
        $this->assertEquals($data['email'], $resp->getData()->email);
        $this->assertEquals($data['phone_number'], $resp->getData()->phone_number);
        $this->assertEquals(Hash::make($data['password'], $resp->getData()->password));
        $this->assertEquals($data['avatar'], $resp->getData()->avatar);
        Storage::assertExists($resp->getData()->avatar);
        $this->assertNotNull(Student::find($resp->getData()->student_id));
        if(!is_null($resp->getData()->admin_id)){
            $this->assertNotNull(Admin::find($resp->getData()->admin_id));
        }
        if(!is_null($resp->getData()->instructor_id)){
            $this->assertNotNull(Instructor::find($resp->getData()->instructor_id));
        }
        if(!is_null($resp->getData()->guardian_id)){
            $this->assertNotNull(Guardian::find($resp->getData()->guardian_id));
        }
        if(!is_null($resp->getData()->manager_id)){
            $this->assertNotNull(Manager::find($resp->getData()->manager_id));
        }
    }

    public function test_update(){
        // Data preparation
        $model = factory(User::class)->create();
        $district = factory(District::class)->create();
        $data = [
            'district_id' =>  $district->id,
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'username' => $this->faker->userName,
            'email' => $this->faker->email,
            'phone_number' => $this->faker->e164PhoneNumber,
            'password' => '123456',
        ];

        // Operations
        $repository = new UserRepository;
        $resp = $repository->update($model->id, $data);

        // Control
        $this->assertInstanceOf('App\Models\Auth\User', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertEquals($data['district_id'], $resp->getData()->district_id);
        $this->assertEquals($data['first_name'], $resp->getData()->first_name);
        $this->assertEquals($data['last_name'], $resp->getData()->last_name);
        $this->assertEquals($data['username'], $resp->getData()->username);
        $this->assertEquals($data['email'], $resp->getData()->email);
        $this->assertEquals($data['phone_number'], $resp->getData()->phone_number);
        $this->assertEquals(Hash::make($data['password']), $resp->getData()->password);
    }

    public function test_update_avatar(){
        // Data preparation
        $model = factory(User::class)->create();
        $file = Storage::fake()->image('user.jpg');
        $data = [
            'avatar' => $file,
        ];

        // Operations
        $repository = new UserRepository;
        $resp = $repository->updateAvatar($model->id, $data);

        // Control
        $this->assertInstanceOf('App\Models\Auth\User', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        Storage::assertMissing($model->avatar);
        Storage::assertExists($resp->getData()->avatar);
    }

    public function test_delete(){
        // Data preparation
        $model = factory(User::class)->create();
        $admin = $model->admin;
        $student = $model->student;
        $guardian = $model->guardian;
        $manager = $model->manager;
        $instructor = $model->instructor;

        // Operations
        $repository = new UserRepository;
        $resp = $repository->delete($model->id);

        // Control
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertTrue($resp->isDataNull());
        $this->assertNull($resp->getData());
        $this->assertNull(User::find($model->id));
        $this->assertNull(Student::find($model->student_id));
        if(!is_null($model->admin_id)){
            $this->assertNull(Admin::find($model->admin_id));
        }
        if(!is_null($model->guardian_id)){
            $this->assertNull(Guardian::find($model->guardian_id));
        }
        if(!is_null($model->manager_id)){
            $this->assertNull(Manager::find($model->manager->id));
        }
        if(!is_null($model->instructor_id)){
            $this->assertNull(Instructor::find($model->instructor_id));
        }
    }

    public function test_set_active(){
        // Data preparation
        $model = factory(User::class)->create(['active' => false]);

        // Operations
        $repository = new UserRepository;
        $resp = $repository->setActive($model->id);

        // Control
        $this->assertInstanceOf('App\Models\Auth\User', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertTrue($resp->getData()->active);
    }

    public function test_set_passive(){
        // Data preparation
        $model = factory(User::class)->create();

        // Operations
        $repository = new UserRepository;
        $resp = $repository->setPassive($model->id);

        // Control
        $this->assertInstanceOf('App\Models\Auth\User', $resp->getData());
        $this->assertTrue($resp->getResult());
        $this->assertNull($resp->getError());
        $this->assertFalse($resp->isDataNull());
        $this->assertFalse($resp->getData()->active);
    }
}
