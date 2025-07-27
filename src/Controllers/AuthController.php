<?php

namespace App\Controllers;

use App\Config; // Import Config class

class AuthController
{
    public function showLogin()
    {
        // Your existing login logic and HTML will go here
        // No change to the logic for handling POST request, but the initial display of the form
        // will be handled here.
        session_start(); // Ensure session is started for all AuthController methods

        // If already logged in, redirect to dashboard
        if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
            header('Location: /dashboard');
            exit();
        }

        $pesan_error = '';
        $user_email_input = $_POST['user_email'] ?? '';
        $password_input = $_POST['password'] ?? ''; // This is not passed back to the form

        // Load the login view, passing necessary variables
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    public function handleLogin()
    {
        session_start(); // Ensure session is started

        $pesan_error = '';
        $user_email_input = $_POST['user_email'] ?? '';
        $password_input = $_POST['password'] ?? '';

        if (empty($user_email_input) || empty($password_input)) {
            $pesan_error = 'Email dan password wajib diisi.';
        } else {
            $data = [
                'user_email' => $user_email_input,
                'user_pass' => $password_input,
            ];

            $api_url = Config::API_BASE_URL . '/login'; // Use Config for API URL

            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_error = curl_error($ch);
            $curl_errno = curl_errno($ch);
            curl_close($ch);

            if ($response === false) {
                $pesan_error = "Kesalahan koneksi API: " . htmlspecialchars($curl_error) . " (Kode: {$curl_errno})";
            } else {
                $response_data = json_decode($response);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $pesan_error = "Gagal memproses respons API: Data bukan JSON valid. Pesan: " . json_last_error_msg();
                } else {
                    if ($http_code == 200) {
                        $_SESSION['logged_in'] = true;
                        $_SESSION['user_email'] = $response_data->user_email ?? $user_email_input;
                        $_SESSION['jwt_token'] = $response_data->jwt ?? null;
                        $_SESSION['user_id'] = $response_data->ID ?? null; // Make sure API returns ID
                        $_SESSION['user_publicname'] = $response_data->user_publicname ?? 'Pengguna';

                        header('Location: /dashboard'); // Redirect to the dashboard route
                        exit();
                    } else {
                        $pesan_error = htmlspecialchars($response_data->message ?? 'Email atau password salah.');
                    }
                }
            }
        }
        // If login fails, reload the login view with the error message
        require_once __DIR__ . '/../Views/auth/login.php';
    }

    public function showSignup()
    {
        session_start();
        $message = "";
        $message_type = "";
        $errors = [];

        // Pre-fill fields if coming from a failed submission
        $user_email = $_SESSION['signup_form_data']['user_email'] ?? '';
        $user_pass = ''; // Never pre-fill passwords
        $user_pass_confirm = '';
        $user_publicname = $_SESSION['signup_form_data']['user_publicname'] ?? '';
        $user_status = $_SESSION['signup_form_data']['user_status'] ?? '0';
        $user_url = $_SESSION['signup_form_data']['user_url'] ?? '';

        if (isset($_SESSION['signup_message'])) {
            $message = $_SESSION['signup_message']['text'];
            $message_type = $_SESSION['signup_message']['type'];
            unset($_SESSION['signup_message']); // Clear message after display
        }
        if (isset($_SESSION['signup_errors'])) {
            $errors = $_SESSION['signup_errors'];
            unset($_SESSION['signup_errors']); // Clear errors after display
        }
        if (isset($_SESSION['signup_form_data'])) {
            unset($_SESSION['signup_form_data']); // Clear data after display
        }

        require_once __DIR__ . '/../Views/auth/signup.php';
    }

    public function handleSignup()
    {
        session_start();

        $errors = [];
        // Capture all POST data to potentially re-populate form
        $user_email = $_POST['user_email'] ?? '';
        $user_pass = $_POST['user_pass'] ?? '';
        $user_pass_confirm = $_POST['user_pass_confirm'] ?? '';
        $user_publicname = $_POST['user_publicname'] ?? '';
        $user_status = $_POST['user_status'] ?? '0';
        $user_url = $_POST['user_url'] ?? '';

        // Store current form data in session in case of errors
        $_SESSION['signup_form_data'] = [
            'user_email' => $user_email,
            'user_publicname' => $user_publicname,
            'user_status' => $user_status,
            'user_url' => $user_url,
        ];

        // Validation (same as your existing signup.php)
        if (empty($user_email)) {
            $errors['user_email'] = "Email wajib diisi.";
        } elseif (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $errors['user_email'] = "Format email tidak valid.";
        }

        if (empty($user_pass)) {
            $errors['user_pass'] = "Password wajib diisi.";
        } elseif (strlen($user_pass) < 6) {
            $errors['user_pass'] = "Password minimal 6 karakter.";
        }

        if (empty($user_pass_confirm)) {
            $errors['user_pass_confirm'] = "Konfirmasi password wajib diisi.";
        } elseif ($user_pass !== $user_pass_confirm) {
            $errors['user_pass_confirm'] = "Password dan konfirmasi password tidak cocok.";
        }

        if (empty($user_publicname)) {
            $errors['user_publicname'] = "Nama Publik wajib diisi.";
        } elseif (strlen($user_publicname) < 3) {
            $errors['user_publicname'] = "Nama Publik minimal 3 karakter.";
        }

        if (!is_numeric($user_status)) {
            $errors['user_status'] = "Status pengguna harus berupa angka.";
        }

        if (!empty($user_url) && !filter_var($user_url, FILTER_VALIDATE_URL)) {
            $errors['user_url'] = "Format URL tidak valid.";
        }

        if (empty($errors)) {
            $data = [
                'user_email' => $user_email,
                'user_pass' => $user_pass,
                'user_status' => (int)$user_status,
                'user_publicname' => $user_publicname,
                'user_url' => $user_url
            ];

            $api_url = Config::API_BASE_URL . '/register'; // Use Config for API URL

            $ch = curl_init($api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

            $response = curl_exec($ch);
            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_error = curl_error($ch);
            curl_close($ch);

            if ($response === false) {
                $_SESSION['signup_message'] = ['text' => "Kesalahan koneksi API: " . htmlspecialchars($curl_error), 'type' => 'error'];
            } else {
                $response_data = json_decode($response);

                if (json_last_error() !== JSON_ERROR_NONE) {
                    $_SESSION['signup_message'] = ['text' => "Gagal memproses respons API: Data bukan JSON valid.", 'type' => 'error'];
                } else {
                    if ($http_code == 201) {
                        $_SESSION['signup_message'] = ['text' => $response_data->message ?? 'Pengguna berhasil ditambahkan. Silakan login.', 'type' => 'success'];
                        // Clear form data from session on success
                        unset($_SESSION['signup_form_data']);
                    } else {
                        $_SESSION['signup_message'] = ['text' => "Gagal menambahkan pengguna. Status HTTP: " . $http_code . ". Pesan: " . htmlspecialchars($response_data->message ?? 'Terjadi kesalahan tidak dikenal.'), 'type' => 'error'];
                    }
                }
            }
        } else {
            $_SESSION['signup_errors'] = $errors;
            $_SESSION['signup_message'] = ['text' => "Terdapat kesalahan input. Mohon periksa kembali form Anda.", 'type' => 'error'];
        }

        header('Location: /signup'); // Redirect back to signup to display messages/errors
        exit();
    }

    public function handleLogout()
    {
        session_start(); // Ensure session is started
        $_SESSION = array(); // Unset all of the session variables.
        session_destroy(); // Destroy the session.
        header('Location: /'); // Redirect to the login page (root)
        exit();
    }
}
