<?php
require_once 'Database.php';

class Product {
    private $conn;
    private $table_name = 'barang';

    public $id;
    public $nama_barang;
    public $deskripsi;
    public $harga;
    public $stok;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // public function create() {
    //     $query = "INSERT INTO " . $this->table_name . " SET nama_barang=:nama_barang, deskripsi=:deskripsi, harga=:harga, stok=:stok";
    //     $stmt = $this->conn->prepare($query);

    //     $this->nama_barang = htmlspecialchars(strip_tags($this->nama_barang));
    //     $this->deskripsi = htmlspecialchars(strip_tags($this->deskripsi));
    //     $this->harga = htmlspecialchars(strip_tags($this->harga));
    //     $this->stok = htmlspecialchars(strip_tags($this->stok));

    //     $stmt->bindParam(':nama_barang', $this->nama_barang);
    //     $stmt->bindParam(':deskripsi', $this->deskripsi);
    //     $stmt->bindParam(':harga', $this->harga);
    //     $stmt->bindParam(':stok', $this->stok);

    //     if ($stmt->execute()) {
    //         return true;
    //     }
    //     return false;
    // }

    public function readAll() {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama_barang=:nama_barang, deskripsi=:deskripsi, harga=:harga, stok=:stok WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->nama_barang = htmlspecialchars(strip_tags($this->nama_barang));
        $this->deskripsi = htmlspecialchars(strip_tags($this->deskripsi));
        $this->harga = htmlspecialchars(strip_tags($this->harga));
        $this->stok = htmlspecialchars(strip_tags($this->stok));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':nama_barang', $this->nama_barang);
        $stmt->bindParam(':deskripsi', $this->deskripsi);
        $stmt->bindParam(':harga', $this->harga);
        $stmt->bindParam(':stok', $this->stok);
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

    public function search($term) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nama_barang LIKE :term";
        $stmt = $this->conn->prepare($query);
        $term = "%$term%";
        $stmt->bindParam(':term', $term);
        $stmt->execute();
        return $stmt;
    }

    public function searchWithPagination($term, $limit, $offset) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE nama_barang LIKE :term LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($query);
        $term = "%$term%";
        $stmt->bindParam(':term', $term);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt;
    }
    
    public function countSearchResults($term) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table_name . " WHERE nama_barang LIKE :term";
        $stmt = $this->conn->prepare($query);
        $term = "%$term%";
        $stmt->bindParam(':term', $term);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET nama_barang=:nama_barang, deskripsi=:deskripsi, harga=:harga, stok=:stok";
        $stmt = $this->conn->prepare($query);
    
        $this->nama_barang = htmlspecialchars(strip_tags($this->nama_barang));
        $this->deskripsi = htmlspecialchars(strip_tags($this->deskripsi));
        $this->harga = htmlspecialchars(strip_tags($this->harga));
        $this->stok = htmlspecialchars(strip_tags($this->stok));
    
        $stmt->bindParam(':nama_barang', $this->nama_barang);
        $stmt->bindParam(':deskripsi', $this->deskripsi);
        $stmt->bindParam(':harga', $this->harga);
        $stmt->bindParam(':stok', $this->stok);
    
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    
}
?>
