<?php

namespace App\Controllers;

class DashboardController
{
    public function index()
    {
        session_start(); // Ensure session is started

        // Periksa apakah pengguna sudah login
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: /'); // Redirect to login route
            exit();
        }

        $user_publicname = $_SESSION['user_publicname'] ?? 'Pengguna';

        require_once __DIR__ . '/../Views/dashboard/index.php';
    }
}
