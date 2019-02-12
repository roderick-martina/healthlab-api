<?php

namespace App\Repositories;

use App\Repositories\Contracts\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Exceptions\NoModelDefined;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

abstract class RepositoryAbstract implements RepositoryInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = $this->resolvemodel();

    }

    public function all(Request $request)
    {
        $models = $this->model->filter($request)->paginate(7);
        return $models;
    }

    public function create(array $properties)
    {
        return $this->model->create($properties);
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findWhereFirst($column, $value)
    {
        return $this->model->where($column, $value)->firstOrFail();
    }

    public function delete($id)
    {
        $model = $this->find($id);
        $model->delete();
        return $model;
    }

    public function withCriteria(...$criteria)
    {
        $criteria = array_flatten($criteria);

        foreach ($criteria as $criterion) {
            $this->model = $criterion->apply($this->model);
        }

        return $this;
    }

    public function update($id, array $properties)
    {
        $model = $this->find($id);
        $model->update($properties);
        return $model;
    }

    public function storeFile(Request $request, string $fileName)
    {
        $file = $request->file($fileName);
        $id = Storage::disk('do')->put('', $file, 'public');
        return $id;
    }

    public function columnList(string $column)
    {
        $list = new Collection();

        $ethnicicties = $this->model->all()->pluck($column)->unique();
        $ethnicicties->each(function ($item, $key) use ($list) {
            $list->push($item);
        });

        return $list;
    }

    protected function resolveModel()
    {
        // Check if model method exist
        if (!\method_exists($this, 'model')) {
            throw new NoModelDefined('No model defined');
        }

        return app()->make($this->model()); //make model
    }


}