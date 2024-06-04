<?php
require_once 'Database.php';

class Customer {
    private $conn;
    private $table_name = 'pelanggan';

    public $id;
    public $nama;
    public $telepon;
    public $alamat;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nama=:nama, telepon=:telepon, alamat=:alamat";
        $stmt = $this->conn->prepare($query);

        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->telepon = htmlspecialchars(strip_tags($this->telepon));
        $this->alamat = htmlspecialchars(strip_tags($this->alamat));

        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':telepon', $this->telepon);
        $stmt->bindParam(':alamat', $this->alamat);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama=:nama, telepon=:telepon, alamat=:alamat WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->nama = htmlspecialchars(strip_tags($this->nama));
        $this->telepon = htmlspecialchars(strip_tags($this->telepon));
        $this->alamat = htmlspecialchars(strip_tags($this->alamat));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nama', $this->nama);
        $stmt->bindParam(':telepon', $this->telepon);
        $stmt->bindParam(':alamat', $this->alamat);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCustomerHistory() {
        $query = "SELECT penjualan.id, penjualan.tanggal_penjualan, penjualan.total 
                  FROM penjualan 
                  WHERE id_pelanggan = :id_pelanggan 
                  ORDER BY tanggal_penjualan DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_pelanggan', $this->id);
        $stmt->execute();
        return $stmt;
    }
    
    public function getName() {
        $query = "SELECT nama FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['nama'];
    }
    
    
}
?>
