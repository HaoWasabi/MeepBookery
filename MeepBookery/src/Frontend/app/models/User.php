<?php
require_once __DIR__ . '/BaseModel.php';

class User extends BaseModel
{
    public function getUserById($userId)
    {
        try {
            $query = "SELECT u.UserID, u.Name, u.Email, u.Role, u.Phone, u.Status, 
                             a.AddressID, a.Address, a.City, a.District, a.Ward 
                      FROM user u 
                      LEFT JOIN address a ON u.AddressID = a.AddressID 
                      WHERE u.UserID = ?";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([$userId]);

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return $user;
            }

            return false;
        } catch (PDOException $e) {
            error_log("Lỗi lấy thông tin người dùng: " . $e->getMessage());
            return false;
        }
    }
    public function updateUser($userId, $userData)
    {
        try {
            $this->conn->beginTransaction();

            // Kiểm tra và cập nhật địa chỉ
            $addressId = null;

            if (isset($userData['Address']) || isset($userData['City']) || isset($userData['District']) || isset($userData['Ward'])) {
                // Lấy thông tin user hiện tại để kiểm tra AddressID
                $stmt = $this->conn->prepare("SELECT AddressID FROM user WHERE UserID = ?");
                $stmt->execute([$userId]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && $user['AddressID']) {
                    // Cập nhật địa chỉ hiện có
                    $addressId = $user['AddressID'];
                    $stmt = $this->conn->prepare("UPDATE address SET Address = ?, City = ?, District = ?, Ward = ? WHERE AddressID = ?");
                    $stmt->execute([
                        $userData['Address'] ?? null,
                        $userData['City'] ?? null,
                        $userData['District'] ?? null,
                        $userData['Ward'] ?? null,
                        $addressId
                    ]);
                } else {
                    // Tạo địa chỉ mới
                    $stmt = $this->conn->prepare("INSERT INTO address (Address, City, District, Ward) VALUES (?, ?, ?, ?)");
                    $stmt->execute([
                        $userData['Address'] ?? null,
                        $userData['City'] ?? null,
                        $userData['District'] ?? null,
                        $userData['Ward'] ?? null
                    ]);
                    $addressId = $this->conn->lastInsertId();
                }
            }

            // Cập nhật thông tin người dùng
            $updateFields = [];
            $params = [];

            // Kiểm tra từng trường có thể cập nhật
            if (isset($userData['Name'])) {
                $updateFields[] = "Name = ?";
                $params[] = $userData['Name'];
            }

            if (isset($userData['Phone'])) {
                $updateFields[] = "Phone = ?";
                $params[] = $userData['Phone'];
            }

            if ($addressId) {
                $updateFields[] = "AddressID = ?";
                $params[] = $addressId;
            }

            // Nếu có trường cần cập nhật
            if (!empty($updateFields)) {
                $query = "UPDATE user SET " . implode(", ", $updateFields) . " WHERE UserID = ?";
                $params[] = $userId;

                $stmt = $this->conn->prepare($query);
                $stmt->execute($params);
            }

            $this->conn->commit();
            return true;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            error_log("Lỗi cập nhật thông tin người dùng: " . $e->getMessage());
            return false;
        }
    }
    
    public function lockUser($userId)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE user SET Status = 0 WHERE UserID = ?");
            return $stmt->execute([$userId]);
        } catch (PDOException $e) {
            error_log("Lỗi khóa tài khoản người dùng: " . $e->getMessage());
            return false;
        }
    }
    public function unlockUser($userId)
    {
        try {
            $stmt = $this->conn->prepare("UPDATE user SET Status = 1 WHERE UserID = ?");
            return $stmt->execute([$userId]);
        } catch (PDOException $e) {
            error_log("Lỗi mở khóa tài khoản người dùng: " . $e->getMessage());
            return false;
        }
    }

    public function getUsers($filters = [])
    {
        try {
            $query = "SELECT u.UserID, u.Name, u.Email, u.Role, u.Phone, u.Status, 
                             a.Address, a.City, a.District, a.Ward
                      FROM user u
                      LEFT JOIN address a ON u.AddressID = a.AddressID
                      WHERE 1=1";

            $params = [];

            // Thêm các điều kiện lọc
            if (isset($filters['role']) && !empty($filters['role'])) {
                $query .= " AND u.Role = ?";
                $params[] = $filters['role'];
            }

            if (isset($filters['status']) && $filters['status'] !== '') {
                $query .= " AND u.Status = ?";
                $params[] = (int) $filters['status'];
            }

            if (isset($filters['search']) && !empty($filters['search'])) {
                $query .= " AND (u.Name LIKE ? OR u.Email LIKE ? OR u.Phone LIKE ?)";
                $searchTerm = "%" . $filters['search'] . "%";
                $params[] = $searchTerm;
                $params[] = $searchTerm;
                $params[] = $searchTerm;
            }

            // Sắp xếp theo ID giảm dần (mới nhất trước)
            $query .= " ORDER BY u.UserID DESC";

            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy danh sách người dùng: " . $e->getMessage());
            return [];
        }
    }
    public function emailExists($email, $excludeUserId = null)
    {
        try {
            $query = "SELECT COUNT(*) FROM user WHERE Email = ?";
            $params = [$email];

            if ($excludeUserId) {
                $query .= " AND UserID != ?";
                $params[] = $excludeUserId;
            }

            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            return (int) $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Lỗi kiểm tra email: " . $e->getMessage());
            return false;
        }
    }
    public function phoneExists($phone, $excludeUserId = null)
    {
        try {
            $query = "SELECT COUNT(*) FROM user WHERE Phone = ?";
            $params = [$phone];

            if ($excludeUserId) {
                $query .= " AND UserID != ?";
                $params[] = $excludeUserId;
            }

            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

            return (int) $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Lỗi kiểm tra số điện thoại: " . $e->getMessage());
            return false;
        }
    }
}
