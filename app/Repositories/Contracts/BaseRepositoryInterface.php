<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Model;

interface BaseRepositoryInterface
{
    /**
     * @param array $parameters
     * @return Model
     */
    public function create(array $parameters): Model;
}
