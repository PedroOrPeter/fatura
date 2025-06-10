<?php

namespace App\Models;

use Exception;
use PDO;

class User
{
    private $db;
    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function tratarCNPJ($cnpj)
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);
        if (preg_match('/^(\d)\1{13}$/', $cnpj)) {
            throw new Exception('CNPJ inválido. Todos os dígitos não podem ser iguais.');
        }
        if (strlen($cnpj) !== 14) {
            throw new Exception('CNPJ inválido. Deve conter 14 dígitos.');
        }
        return $cnpj;
    }

    public function tratarCPF($cpf)
    {
        $cpf = preg_replace('/\D/', '', $cpf);
        if (preg_match('/^(\d)\1{10}$/', $cpf)) {
            throw new Exception('CPF inválido. Todos os dígitos não podem ser iguais.');
        }
        if (strlen($cpf) !== 11) {
            throw new Exception('CPF inválido. Deve conter 11 dígitos.');
        }
        return $cpf;
    }

    public function tratarCPFouCNPJ($cpfOuCnpj)
    {
        $cpfOuCnpj = preg_replace('/\D/', '', $cpfOuCnpj);
        if (strlen($cpfOuCnpj) === 11) {
            return $this->tratarCPF($cpfOuCnpj);
        } elseif (strlen($cpfOuCnpj) === 14) {
            return $this->tratarCNPJ($cpfOuCnpj);
        } else {
            throw new Exception('CPF ou CNPJ inválido. Deve conter 11 ou 14 dígitos.');
        }
    }

    public function verificarCPFExistente($cpf)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE documento = ?");
        $stmt->execute([$cpf]);
        return $stmt->fetchColumn() > 0;
    }

    public function verificarSeECPFouCNPJ($cpfOuCnpj)
    {
        if (strlen($cpfOuCnpj) === 11) {
            return 'CPF';
        } elseif (strlen($cpfOuCnpj) === 14) {
            return 'CNPJ';
        } else {
            throw new Exception('CPF ou CNPJ inválido.');
        }
    }

    public function verificarEmailExistente($email)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    public function verificarEmailValido($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Email inválido.');
        }
        return true;
    }

    public function verificarTelefoneValido($telefone)
    {
        $telefone = preg_replace('/\D/', '', $telefone);
        if (strlen($telefone) < 10 || strlen($telefone) > 11) {
            throw new Exception('Telefone inválido. Deve conter entre 10 e 11 dígitos.');
        }
        return true;
    }

    public function createUser($name, $email, $cpfOuCnpj, $telefone, $password)
    {
        $cpfOuCnpj = $this->tratarCPFouCNPJ($cpfOuCnpj);
        $tipo = $this->verificarSeECPFouCNPJ($cpfOuCnpj);

        if ($tipo === 'CPF' && $this->verificarCPFExistente($cpfOuCnpj)) {
            throw new Exception('CPF já cadastrado.');
        }

        if ($this->verificarEmailExistente($email)) {
            throw new Exception('Email já cadastrado.');
        }
        $this->verificarEmailValido($email);

        if (empty($name) || empty($email) || empty($cpfOuCnpj) || empty($password)) {
            throw new Exception('Todos os campos são obrigatórios.');
        }
        
        $this->verificarTelefoneValido($telefone);

        if (empty($password) || strlen($password) < 6) 
        {
            throw new Exception('A senha é obrigatória e deve ter pelo menos 6 caracteres.');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("INSERT INTO users (name, email, documento, telefone, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $cpfOuCnpj, $telefone, $hash]);
        return $this->db->lastInsertId();
    }

    public function updateUser($id, $name = null, $email = null, $cpfOuCnpj = null, $telefone = null, $password = null)
    {
        $fields = [];
        $params = [];

        if ($name !== null) {
            $fields[] = "name = ?";
            $params[] = $name;
        }
        if ($email !== null) {
            $this->verificarEmailValido($email);
            $fields[] = "email = ?";
            $params[] = $email;
        }
        if ($cpfOuCnpj !== null) {
            $cpfOuCnpj = $this->tratarCPFouCNPJ($cpfOuCnpj);
            $fields[] = "documento = ?";
            $params[] = $cpfOuCnpj;
        }
        if ($telefone !== null) {
            $this->verificarTelefoneValido($telefone);
            $fields[] = "telefone = ?";
            $params[] = $telefone;
        }
        if ($password !== null) {
            if (strlen($password) < 6) {
                throw new Exception('A senha deve ter pelo menos 6 caracteres.');
            }
            $fields[] = "password = ?";
            $params[] = password_hash($password, PASSWORD_DEFAULT);
        }

        if (empty($fields)) {
            throw new Exception("Nenhum dado para atualizar.");
        }

        $params[] = $id;
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }

    public function deleteUser($id)
    {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function showAll()
    {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}