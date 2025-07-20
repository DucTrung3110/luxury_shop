<?php
class UserController extends BaseController {
    
    public function login() {
        if (isLoggedIn()) {
            redirect('?controller=home');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = sanitize($_POST['email']);
            $password = $_POST['password'];
            
            $userModel = new User();
            $user = $userModel->login($email, $password);
            
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];
                
                $_SESSION['success'] = 'Welcome back, ' . $user['name'] . '!';
                redirect('?controller=home');
            } else {
                $_SESSION['error'] = 'Invalid email or password';
            }
        }
        
        $this->render('users/login');
    }
    
    public function register() {
        if (isLoggedIn()) {
            redirect('?controller=home');
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = sanitize($_POST['name']);
            $email = sanitize($_POST['email']);
            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];
            
            if (empty($name) || empty($email) || empty($password)) {
                $_SESSION['error'] = 'All fields are required';
            } elseif ($password !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match';
            } elseif (!$this->validatePassword($password)) {
                $_SESSION['error'] = 'Password must be at least 8 characters and contain uppercase, lowercase, number, and special character';
            } else {
                $userModel = new User();
                
                if ($userModel->emailExists($email)) {
                    $_SESSION['error'] = 'Email already exists';
                } else {
                    $userId = $userModel->create([
                        'name' => $name,
                        'email' => $email,
                        'password' => password_hash($password, PASSWORD_DEFAULT)
                    ]);
                    
                    if ($userId) {
                        $_SESSION['success'] = 'Registration successful! Please log in.';
                        redirect('?controller=users&action=login');
                    } else {
                        $_SESSION['error'] = 'Registration failed';
                    }
                }
            }
        }
        
        $this->render('users/register');
    }
    
    public function profile() {
        $this->requireLogin();
        
        $userModel = new User();
        $user = $userModel->getById($_SESSION['user_id']);
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = sanitize($_POST['name']);
            $phone = sanitize($_POST['phone']);
            $address = sanitize($_POST['address']);
            
            if (empty($name)) {
                $_SESSION['error'] = 'Name is required';
            } else {
                $updated = $userModel->update($_SESSION['user_id'], [
                    'name' => $name,
                    'phone' => $phone,
                    'address' => $address
                ]);
                
                if ($updated) {
                    $_SESSION['user_name'] = $name;
                    $_SESSION['success'] = 'Profile updated successfully';
                    $user = $userModel->getById($_SESSION['user_id']);
                } else {
                    $_SESSION['error'] = 'Update failed';
                }
            }
        }
        
        $this->render('users/profile', ['user' => $user]);
    }
    
    public function changePassword() {
        $this->requireLogin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $currentPassword = $_POST['current_password'];
            $newPassword = $_POST['new_password'];
            $confirmPassword = $_POST['confirm_password'];
            
            if (empty($currentPassword) || empty($newPassword)) {
                $_SESSION['error'] = 'All fields are required';
            } elseif ($newPassword !== $confirmPassword) {
                $_SESSION['error'] = 'Passwords do not match';
            } elseif (!$this->validatePassword($newPassword)) {
                $_SESSION['error'] = 'Password must be at least 8 characters and contain uppercase, lowercase, number, and special character';
            } else {
                $userModel = new User();
                $user = $userModel->getById($_SESSION['user_id']);
                
                if (password_verify($currentPassword, $user['password'])) {
                    $updated = $userModel->update($_SESSION['user_id'], [
                        'password' => password_hash($newPassword, PASSWORD_DEFAULT)
                    ]);
                    
                    if ($updated) {
                        $_SESSION['success'] = 'Password changed successfully';
                    } else {
                        $_SESSION['error'] = 'Password change failed';
                    }
                } else {
                    $_SESSION['error'] = 'Current password is incorrect';
                }
            }
        }
        
        redirect('?controller=users&action=profile');
    }
    
    public function uploadProfileImage() {
        $this->requireLogin();
        header('Content-Type: application/json');
        
        if (!isset($_FILES['profile_image']) || $_FILES['profile_image']['error'] !== UPLOAD_ERR_OK) {
            echo json_encode(['success' => false, 'message' => 'No file uploaded or upload error']);
            exit;
        }
        
        try {
            $file = $_FILES['profile_image'];
            
            // Validate file type
            $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = strtolower($file['type']);
            if (!in_array($fileType, $allowedTypes)) {
                throw new Exception('Invalid file type');
            }
            
            // Validate file size (5MB max)
            if ($file['size'] > 5 * 1024 * 1024) {
                throw new Exception('File size too large');
            }
            
            // Create uploads directory if it doesn't exist
            $uploadDir = 'uploads/profiles/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            
            // Generate unique filename
            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
            $targetPath = $uploadDir . $fileName;
            
            // Move uploaded file
            if (move_uploaded_file($file['tmp_name'], $targetPath)) {
                // Update user profile with new image
                $userModel = new User();
                
                // Delete old profile image if it exists
                $user = $userModel->getById($_SESSION['user_id']);
                if (!empty($user['profile_image']) && file_exists('uploads/profiles/' . $user['profile_image'])) {
                    unlink('uploads/profiles/' . $user['profile_image']);
                }
                
                // Update database
                $updated = $userModel->update($_SESSION['user_id'], ['profile_image' => $fileName]);
                
                if ($updated) {
                    echo json_encode([
                        'success' => true, 
                        'message' => 'Profile image updated successfully',
                        'image_url' => $targetPath
                    ]);
                } else {
                    // Delete uploaded file if database update failed
                    unlink($targetPath);
                    echo json_encode(['success' => false, 'message' => 'Database update failed']);
                }
            } else {
                throw new Exception('Failed to save file');
            }
            
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
    
    public function logout() {
        session_destroy();
        redirect('?controller=home');
    }
    
    private function validatePassword($password) {
        // At least 8 characters, uppercase, lowercase, number, and special character
        return strlen($password) >= 8 &&
               preg_match('/[A-Z]/', $password) &&
               preg_match('/[a-z]/', $password) &&
               preg_match('/[0-9]/', $password) &&
               preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
    }
}
?>
