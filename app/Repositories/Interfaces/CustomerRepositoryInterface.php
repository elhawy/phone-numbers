<?php

namespace App\Repositories\Interfaces;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
    public function list(array $options);
}
