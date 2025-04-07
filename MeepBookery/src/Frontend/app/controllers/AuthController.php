<?php
require_once __DIR__ . '/../models/Auth.php';
require_once __DIR__ . '/BaseController.php';

class AuthController extends BaseController
{
    private $authModel;

    public function __construct()
    {
        $this->authModel = new Auth();
    }

    public function login()
    {
        $this->requirePost();

        $data = $this->getRequestData();
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $user = $this->authModel->login($email, $password);

        // Kiểm tra nếu là tài khoản admin
        if ($this->authModel->isAdmin($user)) {
            $this->responseJson([
                'success' => false,
                'message' => 'Email hoặc mật khẩu không chính xác'
            ]);
            return;
        }

        // Kiểm tra nếu là lỗi
        if (isset($user['error'])) {
            $message = match ($user['error']) {
                'invalid_credentials' => 'Email hoặc mật khẩu không chính xác',
                'account_locked' => 'Tài khoản của bạn đã bị khóa',
                default => 'Đã xảy ra lỗi, vui lòng thử lại'
            };

            $this->responseJson([
                'success' => false,
                'message' => $message
            ]);
            return;
        }

        // Lưu session nếu đăng nhập thành công
        $_SESSION['UserID'] = $user['UserID'];
        $_SESSION['Name'] = $user['Name'];
        $_SESSION['Role'] = $user['Role'];

        $this->responseJson([
            'success' => true,
            'message' => 'Đăng nhập thành công'
        ]);
    }

    public function register()
    {
        // Kiểm tra phương thức POST
        $this->requirePost();

        // Lấy dữ liệu từ request
        $data = $this->getRequestData();
        $fullName = $data['fullName'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        // Kiểm tra email đã tồn tại chưa
        if ($this->authModel->emailExists($email)) {
            $this->responseJson([
                'success' => false,
                'message' => 'Email này đã được sử dụng, vui lòng chọn email khác'
            ]);
            return;
        }

        // Đăng ký người dùng mới
        $result = $this->authModel->register($fullName, $email, $password);

        if ($result) {
            // Đăng nhập người dùng sau khi đăng ký thành công
            $user = $this->authModel->login($email, $password);

            if ($user) {
                $_SESSION['UserID'] = $user['UserID'];
                $_SESSION['Name'] = $user['Name'];
                $_SESSION['Role'] = $user['Role'];
            }

            $this->responseJson([
                'success' => true,
                'message' => 'Đăng ký thành công'
            ]);
        } else {
            $this->responseJson([
                'success' => false,
                'message' => 'Đăng ký thất bại, vui lòng thử lại sau'
            ]);
        }
    }

    public function logout()
    {
        // Xóa tất cả dữ liệu session
        $_SESSION = array();

        // Xóa cookie phiên
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        // Hủy phiên
        session_destroy();

        // Chuyển hướng về trang chủ
        $this->redirect('/');
    }
}
