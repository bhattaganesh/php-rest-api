<?php

namespace Ganesh\PhpRestApi\Controllers;

use Ganesh\PhpRestApi\Models\UserModel;
use Ganesh\PhpRestApi\Validation\Validation;


class UserController extends Controller
{

    public function __construct()
    {
        $this->model =  new UserModel();
        parent::__construct($this->model);
    }

    public function getById($id)
    {
        try {
            $data = $this->model->getById($id);

            if (empty($data)) {
                sendResponse(404, false, 'No data found.', []);
            }

            sendResponse(200, true, 'Data retrieved successfully.', $data);
        } catch (\Exception $e) {
            sendResponse(500, false, 'Error retrieving data: ' . $e->getMessage(), []);
        }
    }

    public function create()
    {
        try {
            $input_data = json_decode(file_get_contents('php://input'), true);

            $input_data = $this->sanitize_and_escaping($input_data);

            $rules = [
                'name' => 'required|min:3',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ];

            if (Validation::validate($input_data, $rules)) {

                // Password hash.
                if (isset($input_data['password'])) {
                    $input_data['password'] = password_hash($input_data['password'], PASSWORD_BCRYPT);
                }

                $data = $this->model->create($input_data);

                if (empty($data)) {
                    sendResponse(404, false, 'No data created.', []);
                }

                sendResponse(200, true, 'Data created successfully.', $data);
            }
        } catch (\Exception $e) {
            sendResponse(500, false, 'Error creating data: ' . $e->getMessage(), []);
        }
    }

    public function update($id)
    {
        try {
            $input_data = json_decode(file_get_contents('php://input'), true);

            $input_data = $this->sanitize_and_escaping($input_data);

            $rules = [
                'name' => 'required|min:3',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ];

            if (Validation::validate($input_data, $rules)) {
                // Password hash.
                if (isset($input_data['password'])) {
                    $input_data['password'] = password_hash($input_data['password'], PASSWORD_BCRYPT);
                }

                $data = $this->model->update($id, $input_data);

                if (empty($data)) {
                    sendResponse(404, false, 'No data updated.', []);
                }

                sendResponse(200, true, 'Data updated successfully.', $data);
            }
        } catch (\Exception $e) {
            sendResponse(500, false, 'Error updating data: ' . $e->getMessage(), []);
        }
    }

    public function delete($id)
    {
        try {
            $data = $this->model->delete($id);

            if (empty($data)) {
                sendResponse(404, false, 'No data deleted.', []);
            }

            sendResponse(200, true, 'Data deleted successfully.', $data);
        } catch (\Exception $e) {
            sendResponse(500, false, 'Error deleting data: ' . $e->getMessage(), []);
        }
    }

    private function sanitize_and_escaping($data)
    {
        if (!empty($data)) {
            $clean_data = array();
            foreach ($data as $key => $field) {
                //Sanitization.
                $field = sanitize($field);

                // Escaping.
                $field = escape($field);

                $clean_data[$key] = $field;
            }

            return $clean_data;
        }

        return $data;
    }
}
