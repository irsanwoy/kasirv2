<?php
require_once 'Database.php';

class Sale {
    private $conn;
    private $table_name = 'penjualan';
    private $detail_table_name = 'detail_penjualan';

    public $id;
    public $id_pengguna;
    public $id_pelanggan;
    public $total;
    public $tanggal_penjualan;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function create() {
        $query = "INSERT INTO " . $this->table_name . " SET id_pengguna=:id_pengguna, id_pelanggan=:id_pelanggan, total=:total";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_pengguna', $this->id_pengguna);
        $stmt->bindParam(':id_pelanggan', $this->id_pelanggan);
        $stmt->bindParam(':total', $this->total);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    public function addDetail($id_barang, $jumlah, $harga) {
        $query = "INSERT INTO " . $this->detail_table_name . " SET id_penjualan=:id_penjualan, id_barang=:id_barang, jumlah=:jumlah, harga=:harga";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_penjualan', $this->id);
        $stmt->bindParam(':id_barang', $id_barang);
        $stmt->bindParam(':jumlah', $jumlah);
        $stmt->bindParam(':harga', $harga);

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

    public function readDetails() {
        $query = "SELECT * FROM " . $this->detail_table_name . " WHERE id_penjualan = :id_penjualan";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_penjualan', $this->id);
        $stmt->execute();
        return $stmt;
    }

    public function readAllWithNames() {
        $query = "SELECT penjualan.id, pengguna.nama_pengguna, pelanggan.nama AS nama_pelanggan, penjualan.total, penjualan.tanggal_penjualan
                  FROM " . $this->table_name . "
                  JOIN pengguna ON penjualan.id_pengguna = pengguna.id
                  JOIN pelanggan ON penjualan.id_pelanggan = pelanggan.id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOne() {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $query = "UPDATE " . $this->table_name . " SET id_pengguna=:id_pengguna, id_pelanggan=:id_pelanggan, total=:total WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $this->id_pengguna = htmlspecialchars(strip_tags($this->id_pengguna));
        $this->id_pelanggan = htmlspecialchars(strip_tags($this->id_pelanggan));
        $this->total = htmlspecialchars(strip_tags($this->total));
        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(':id_pengguna', $this->id_pengguna);
        $stmt->bindParam(':id_pelanggan', $this->id_pelanggan);
        $stmt->bindParam(':total', $this->total);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getSalesReport($period) {
        $date_format = '';
        switch ($period) {
            case 'daily':
                $date_format = '%Y-%m-%d';
                break;
            case 'weekly':
                $date_format = '%Y-%u';
                break;
            case 'monthly':
                $date_format = '%Y-%m';
                break;
            case 'yearly':
                $date_format = '%Y';
                break;
        }
    
        $query = "SELECT DATE_FORMAT(tanggal_penjualan, '$date_format') as date, SUM(total) as total 
                  FROM " . $this->table_name . " 
                  GROUP BY date 
                  ORDER BY date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function readOneWithDetails() {
        $query = "SELECT penjualan.id, penjualan.tanggal_penjualan, penjualan.total, pengguna.nama_pengguna, pelanggan.nama AS nama_pelanggan
                  FROM penjualan
                  JOIN pengguna ON penjualan.id_pengguna = pengguna.id
                  JOIN pelanggan ON penjualan.id_pelanggan = pelanggan.id
                  WHERE penjualan.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $sale = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $query = "SELECT detail_penjualan.id, barang.nama_barang, detail_penjualan.jumlah, detail_penjualan.harga, (detail_penjualan.jumlah * detail_penjualan.harga) as total
                  FROM detail_penjualan
                  JOIN barang ON detail_penjualan.id_barang = barang.id
                  WHERE detail_penjualan.id_penjualan = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $sale['details'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        return $sale;
    }
    
    
}
?>
