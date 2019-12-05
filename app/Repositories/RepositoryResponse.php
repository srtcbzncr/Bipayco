<?php

namespace App\Repositories;

class RepositoryResponse implements IRepositoryResponse{

    private $result;
    private $data;
    private $error;

    public function __construct($result=null, $data=null, $error=null)
    {
        $this->result = $result;
        $this->data = $data;
        $this->error = $error;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getError()
    {
        return $this->error;
    }
}
