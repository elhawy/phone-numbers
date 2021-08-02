<?php

namespace App\Repositories;

use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    private $validPhonePattern = '\(251\) ?[1-59]\d{8}$|\(237\)\ ?[2368]\d{7,8}$|\(256\)\ ?\d{9}$|\(258\)\ ?[28]\d{7,8}$|\(212\)\ ?[5-9]\d{8}$';
    public function __construct()
    {
        $this->model = new Customer();
    }

    public function list(array $options)
    {
        if (isset($options['code'])) {
            $pattern = '\('.$options['code'].'\) ?[0-9]+';
            $this->model = $this->model->whereRaw("phone REGEXP '".$pattern."'");
        }
        if (isset($options['is_valid'])) {
            if ($options['is_valid']) {
                $this->model = $this->model->whereRaw("phone REGEXP '". $this->validPhonePattern."'");
            } else {
                $this->model = $this->model->whereRaw("phone NOT REGEXP '". $this->validPhonePattern."'");
            }
        }
        return $this->model->paginate($options['per_page'] ?? 15);
    }
}
