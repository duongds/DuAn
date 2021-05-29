<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

abstract class BaseRepository
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    protected $query;

    /**
     * Get searchable fields array
     *
     * @return array
     */
    abstract public function getFieldsSearchable();

    /**
     * @var List field filter
     */
    protected $fieldFilter = [];

    /**
     * @var List field show in query list
     */
    protected $fieldInList = [];

    /**
     * @var List field order
     */
    protected $fieldOrder = [];

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

    /**
     * Retrieve all records with given filter criteria
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $columns
     *
     * @param array $orders
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function all($search = [], $skip = null, $limit = null, $columns = ['*'], $orders = [])
    {
        if ($columns == null) {
            if (!empty($this->fieldInList)) {
                $columns = $this->fieldInList;
            } else $columns = ['*'];
        }

        $this->allQuery($search, $skip, $limit, $orders);

        if (method_exists($this, 'beforeAllQuery')) {
            $this->beforeAllQuery();
        }

        return $this->query->get($columns);
    }

    /**
     * Paginate records for scaffold.
     *
     * @param array $search
     * @param int $perPage
     * @param array $columns
     * @param array $orders
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate($search = [],$perPage=1, $columns = ['*'], $orders = [])
    {
        if ($columns == null) {
            if (!empty($this->fieldInList)) {
                $columns = $this->fieldInList;
            } else $columns = ['*'];
        }
        $this->allQuery($search, null, null, $orders);

        if (method_exists($this, 'beforeAllQuery')) {
            $this->beforeAllQuery();
        }

        return $this->query->paginate($perPage, $columns);
    }

    /**
     * Build a query for retrieving all records.
     *
     * @param array $search
     * @param int|null $skip
     * @param int|null $limit
     * @param array $orders
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function allQuery($search = [], $skip = null, $limit = null, $orders = [])
    {
        $this->query = $this->model->newQuery();

        if (count($search)) {
            foreach ($search as $key => $value) {
                if (in_array($key, $this->getFieldsSearchable())) {
                    $method = 'filter' . Str::studly($key);
                    if (method_exists($this, $method)) {
                        $this->{$method}($value);
                    } else if (method_exists($this->model, $method)) {
                        $this->query = $this->model->{$method}($this->query, $value);
                    } else {
                        $this->query->where($key, $value);
                    }
                } else if ($key == "filter") {
                    if (method_exists($this, 'filter')) {
                        $this->filter($value);
                    } else if (count($this->fieldFilter)) {
                        $value = $this->processSearch($value);
                        $this->query->where(function ($query) use ($value) {
                            foreach ($this->fieldFilter as $field) {
                                $query->orWhere($field, 'like', "%$value%");
                            }
                        });
                    }
                }
            }
        }

        if (is_array($orders) and count($orders)) {
            foreach ($orders as $orderBy => $orderDir) {
                $orderBy = (in_array($orderBy, $this->fieldOrder)) ? $orderBy : $this->fieldOrder[0];
                $this->query->orderBy($orderBy, $orderDir);
            }
        }

        if (!is_null($limit)) {
            $this->query->limit($limit);

            if (!is_null($skip)) {
                $this->query->skip($skip);
            }
        }

        return $this->query;
    }

    public function processSearch($input_search = "")
    {
        return addcslashes($input_search, '0!@#$%^&*\()_-+');
    }

    public function uploadImage($path, $file, $old_data = null)
    {
        if (!is_null($old_data) && is_file(public_path() . $old_data)){
            unlink(public_path() . $old_data);
        }
        $filename = $file->getClientOriginalName();
        $name = '/storage/image/' . $path .'/' . $filename;
        $file->move(public_path() . '/storage/image/' . $path . '/', $filename);
        return $name;
    }
}

