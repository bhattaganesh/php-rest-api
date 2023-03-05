<?php

namespace Ganesh\PhpRestApi\Controllers;

class Controller
{
    protected $model;

    protected $request;

    public function __construct($model)
    {
        $this->model = $model;
        $this->request = $_REQUEST;
    }

    public function getAll()
    {

        try {
            $data = $this->model->getAll();

            if (empty($data)) {
                sendResponse(404, false, 'No data found.', []);
            }

            sendResponse(200, true, 'Data retrieved successfully.', $data);
        } catch (\Exception $e) {
            sendResponse(500, false, 'Error retrieving data: ' . $e->getMessage(), []);
        }
    }
}
