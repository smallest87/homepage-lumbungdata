<a href="#" onclick="loginWithGoogle()">Login dengan Google</a>

<script>
function loginWithGoogle() {
    const clientId = '419908790974-g2l3pnd6p7aalr5fufnvkbj0793aqvjg.apps.googleusercontent.com'; // Ganti dengan Client ID Anda
    const redirectUri = encodeURIComponent('https://auth.lumbungdata.com/callback.php'); // URL callback Anda
    const scope = encodeURIComponent('https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile openid'); // Izin yang diminta
    const state = generateRandomString(); // Fungsi untuk membuat string acak yang unik per sesi
    
    // Simpan 'state' ini di sesi pengguna (session storage, cookie, atau database) di sisi server
    // untuk validasi saat callback diterima. PENTING untuk keamanan!
    localStorage.setItem('oauth_state', state); // Contoh sederhana, idealnya di sisi server

    const authUrl = `https://accounts.google.com/o/oauth2/v2/auth?` +
                    `client_id=${clientId}&` +
                    `redirect_uri=${redirectUri}&` +
                    `response_type=code&` + // Penting: 'code' untuk alur kode otorisasi
                    `scope=${scope}&` +
                    `state=${state}&` +
                    `access_type=offline`; // Untuk mendapatkan refresh token
                    
    window.location.href = authUrl;
}

// Fungsi sederhana untuk menghasilkan string acak (gunakan yang lebih kuat di produksi!)
function generateRandomString() {
    return Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15);
}
</script>