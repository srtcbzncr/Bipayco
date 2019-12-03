<?php

namespace App\Repositories;
use Illuminate\Http\Request;

interface IRepository{
    public function all();
    public function get($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function setActive($id);
    public function setPassive($id);
}
