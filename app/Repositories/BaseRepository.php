<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Schema;

abstract class BaseRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    protected $query;

    /**
     * EloquentRepository constructor.
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct()
    {
        $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function setModel()
    {
        return $this->model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {

        return $this->model->all();
    }

    /**
     * Get one
     * @param $id
     * @param array $columns
     * @return mixed
     */
    public function find($id, $columns = ['*'])
    {
        $this->query = $this->model->newQuery();

        return $this->query->find($id, $columns);
    }

    /**
     * get exits columns of model
     * @param $name
     * @return bool
     */
    private function exitsProperty($name)
    {
        return Schema::hasColumn($this->model->getTable(), $name);
    }

    /**
     * Create
     * @param $input
     * @return mixed
     */
    public function create($input)
    {
        $user = \Auth::user();

        $model = $this->model->newInstance($input);

        // set created_by
        if (\Auth::check() AND $this->exitsProperty('created_by')) {
            $model->created_by = $user->id;
        }
        $model->save();

        return $model;
    }

    /**
     * Update
     * @param $input
     * @param $id
     * @return bool|mixed
     */
    public function update($input, $id)
    {
        $user = \Auth::user();
        $this->query = $this->model->newQuery();

        $model = $this->query->findOrFail($id);

        // update, remove id
        if (isset($input['id'])) unset($input['id']);

        // not allow set created_by, modified_by
        if (isset($input['created_by'])) unset($input['created_by']);
        if (isset($input['updated_by'])) unset($input['modified_by']);

        // set created_by
        if (\Auth::check() AND $this->exitsProperty('created_by') AND !$model->created_by) {
            $model->created_by = $user->id;
        }

        // set modified_by
        if (\Auth::check() AND $this->exitsProperty('modified_by')) {
            $model->modified_by = $user->id;
        }

        $model->fill($input);

        $model->save();

        return $model;
    }

    /**
     * @param int $id
     *
     * @return bool|mixed|null
     * @throws \Exception
     *
     */
    public function delete($id)
    {
        $user = \Auth::user();
        $this->query = $this->model->newQuery();

        $model = $this->query->findOrFail($id);

        // set deleted_by
        if (\Auth::check() AND $this->exitsProperty('deleted_by')) {
            $model->deleted_by = $user->id;
        }
        $model->save();

        return $model->delete();
    }

}

