<?php
require_once __DIR__ . '/../../config/database.php';

class Address
{
    private $conn;
    private $table = "address";

    public function __construct()
    {
        try {
            $database = new Database();
            $this->conn = $database->getConnection();
        } catch (PDOException $e) {
            error_log("Lỗi kết nối DB: " . $e->getMessage());
            die("Không thể kết nối đến cơ sở dữ liệu.");
        }
    }

    public function getAll()
    {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $query = "SELECT * FROM " . $this->table . " WHERE AddressID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getUserAddress($userId)
    {
        $query = "SELECT a.AddressID, a.Address, a.City, a.District, a.Ward 
                  FROM User u 
                  JOIN Address a ON u.AddressID = a.AddressID
                  WHERE u.UserID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($address, $city, $district, $ward)
    {
        $query = "INSERT INTO " . $this->table . " (Address, City, District, Ward) VALUES (?, ?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$address, $city, $district, $ward]);
        return $this->conn->lastInsertId();
    }

    public function update($id, $address, $city, $district, $ward)
    {
        $query = "UPDATE " . $this->table . " SET Address = ?,  City = ?, District = ?, Ward = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$address, $city, $district, $ward, $id]);
    }

    public function delete($id)
    {
        $query = "DELETE FROM " . $this->table . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
