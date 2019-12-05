<?php

namespace App\Repositories;

interface IRepositoryResponse{
    public function getResult();
    public function getData();
    public function getError();
    public function isDataNull();
}
