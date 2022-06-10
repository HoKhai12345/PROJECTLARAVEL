<?php
namespace App\Repositories;

use Illuminate\Support\Facades\Auth;

abstract class RepositoryAbstract implements RepositoryInterface {
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $_model;

    /**
     * EloquentRepository constructor.
     */
    public function __construct()
    {
        $this->_model = $this->setModel();
    }

    /**
     * get model
     * @return string
     */
    abstract public function getModel();

    /**
     * Set model
     */
    public function setModel()
    {
       return $this->_model = app()->make(
            $this->getModel()
        );
    }

    /**
     * Get All
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll()
    {
        return $this->_model->all();
    }

    /**
     * Get one
     * @param $id
     * @return mixed
     */
    public function find($id, $list_select = '*')
    {
        $result = $this->_model->select($list_select)->where('id', $id)->first();
        return $result;
    }

    /**
     * Create
     * @param array $attributes
     * @return mixed
     */
    public function create(array $attributes)
    {
        return $this->_model->create($attributes);
    }

    /**
     * Update
     * @param $id
     * @param array $attributes
     * @return bool|mixed
     */
    public function update($id, array $attributes)
    {
        $result = $this->find($id);
        if($result) {
            $result->update($attributes);
            return $result;
        }
        return false;
    }

    /**
     * Delete
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $result = $this->find($id);
        if($result) {
            $result->delete();
            return true;
        }

        return false;
    }

    /**
     * Get User login
     * @return bool|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUserLogin() {
        $user = Auth::user();
        if(!$user) {
            return false;
        }

        return $user;
    }
}

?>