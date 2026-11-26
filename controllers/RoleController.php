
<?php

require_once __DIR__ . '/../models/RoleModel.php';

class RoleController
{
    private $model;

    public function __construct($db)
    {
        $this->model = new RoleModel($db);
    }

    public function index()
    {
        return $this->model->getAll();
    }

    public function add($name)
    {
        return $this->model->add($name);
    }

    public function update($id, $name)
    {
        return $this->model->update($id, $name);
    }

    public function delete($id)
    {
        return $this->model->delete($id);
    }
}
