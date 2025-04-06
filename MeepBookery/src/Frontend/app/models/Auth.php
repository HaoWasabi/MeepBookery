<?php
require_once __DIR__ . '/BaseModel.php';

class Auth extends BaseModel
{
    // 1. Kiểm tra thông tin đăng nhập
    public function login($email, $password)
    {
        try {
            // Lấy thông tin user theo email
            $stmt = $this->conn->prepare("SELECT UserID, Name, Password, Role, Status FROM user WHERE Email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Không tìm thấy người dùng
            if (!$user) {
                return ['error' => 'invalid_credentials'];
            }

            // Tài khoản bị khóa
            if ((int) $user['Status'] === 0) {
                return ['error' => 'account_locked'];
            }

            // Kiểm tra mật khẩu
            if (!password_verify($password, $user['Password'])) {
                return ['error' => 'invalid_credentials'];
            }

            // Trả về thông tin user nếu đăng nhập thành công
            return $user;

        } catch (PDOException $e) {
            error_log("Lỗi đăng nhập: " . $e->getMessage());
            return ['error' => 'server_error'];
        }
    }


    // 2. Đăng ký người dùng mới
    public function register($fullName, $email, $password, $role = 'user')
    {
        try {
            // Mã hóa mật khẩu trước khi lưu
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Thêm người dùng vào bảng user
            $stmt = $this->conn->prepare("INSERT INTO user (Name, Email, Password, Role) VALUES (?, ?, ?, ?)");
            return $stmt->execute([$fullName, $email, $hashedPassword, $role]);
        } catch (PDOException $e) {
            error_log("Lỗi đăng ký: " . $e->getMessage());
            return false;
        }
    }

    // 3. Lấy thông tin người dùng theo ID
    public function getUserById($userId)
    {
        try {
            $stmt = $this->conn->prepare("SELECT UserID, Name, Email, Role FROM user WHERE UserID = ?");
            $stmt->execute([$userId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi lấy thông tin người dùng: " . $e->getMessage());
            return false;
        }
    }

    // 4. Kiểm tra xem người dùng có phải là admin hay không
    public function isAdmin($user)
    {
        return isset($user['Role']) && $user['Role'] === 'admin';
    }

    // 5. Kiểm tra xem email đã tồn tại chưa
    public function emailExists($email)
    {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) FROM user WHERE Email = ?");
            $stmt->execute([$email]);
            $count = $stmt->fetchColumn();
            return $count > 0;
        } catch (PDOException $e) {
            error_log("Lỗi kiểm tra email: " . $e->getMessage());
            return false;
        }
    }
}