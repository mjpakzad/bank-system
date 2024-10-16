<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    /**
     * @return string
     */
    abstract public function getModelName(): string;

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return app($this->getModelName());
    }

    /**
     * @param array $parameters
     * @return Model
     */
    public function create(array $parameters): Model
    {
        return $this->getModel()->query()->create($parameters);
    }
}
