<?php
require_once 'Database.php';

class User {
    private $conn;
    private $table_name = 'pengguna';

    public $id;
    public $nama_pengguna;
    public $kata_sandi;
    public $peran;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function register() {
        if($this->conn == null) {
            echo "Connection error: Unable to connect to the database.";
            return false;
        }
        
        $query = "INSERT INTO " . $this->table_name . " SET nama_pengguna=:nama_pengguna, kata_sandi=:kata_sandi, peran=:peran";
        $stmt = $this->conn->prepare($query);

        $this->nama_pengguna = htmlspecialchars(strip_tags($this->nama_pengguna));
        $this->kata_sandi = password_hash($this->kata_sandi, PASSWORD_BCRYPT);
        $this->peran = htmlspecialchars(strip_tags($this->peran));

        $stmt->bindParam(':nama_pengguna', $this->nama_pengguna);
        $stmt->bindParam(':kata_sandi', $this->kata_sandi);
        $stmt->bindParam(':peran', $this->peran);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function login() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nama_pengguna = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->nama_pengguna);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row && password_verify($this->kata_sandi, $row['kata_sandi'])) {
            $this->id = $row['id'];
            $this->peran = $row['peran'];
            return true;
        }
        return false;
    }
}
?>
