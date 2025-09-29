<?php

class Conexao
{
    private $host = 'localhost';
    private $dbname = 'Sharan-Hotel';
    private $username = 'root';
    private $password = '';
    private $pdo;

    // Conecta ao banco de dados
    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Conexão falhou: " . $e->getMessage();
        }
    }


    public function getPdo()
    {
        return $this->pdo;
    }
}
