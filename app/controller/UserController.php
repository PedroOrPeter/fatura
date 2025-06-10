<?php

class UserController {
    private $model;

    public function __construct($db) {
        $this->model = new \App\Models\User($db);
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'home';

        switch ($action) {
            case 'create':
                $this->createUser();
                break;
            case 'edit':
                $this->editUser();
                break;
            case 'delete':
                $this->deleteUser();
                break;
            case 'list':
                $this->listUsers();
                break;
            default:
                include __DIR__ . '/../views/home.php';
                break;
        }
    }

    private function createUser() {
        $data = $_POST;
        try {
            $id = $this->model->createUser(
                $data['name'],
                $data['email'],
                $data['cpfOrcnpj'],
                $data['telefone'],
                $data['password']
            );
            echo json_encode(['status' => 'success', 'id' => $id]);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
    private function editUser() {
        $data = $_POST;
        try {
            $this->model->updateUser(
                $data['id'],
                $data['name'],
                $data['email'],
                $data['cpfOrcnpj'],
                $data['telefone'],
                !empty($data['password']) ? $data['password'] : null
            );
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function deleteUser() {
        $id = $_POST['id'];
        $this->model->deleteUser($id);
        echo json_encode(['status' => 'success']);
    }

    private function listUsers() {
        echo json_encode($this->model->showAll());
    }
}
