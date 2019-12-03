<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface IRepository{
    public function All();
    public function Get($id);
    public function Create(Request $request);
    public function Update($id, Request $request);
    public function Delete($id);
    public function SetActive($id);
    public function SetPassive($id);
}
