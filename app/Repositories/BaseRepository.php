<?php

namespace App\Repositories;

use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    public Model $model;
    public function __construct(Container $container)
    {
        $this->model = $container->make($this->getModelClass());
    }

    public function find(int $id, $columns = ['*']): ?Model
    {
        return $this->model->find($id, $columns);
    }

    public abstract function getModelClass(): string;
}
