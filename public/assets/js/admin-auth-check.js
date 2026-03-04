/**
 * Admin Auth Check
 * Script ini akan mengecek apakah admin sudah login
 * Jika belum, redirect ke halaman login
 */

(function() {
    // Cek apakah ini halaman login/auth (skip checking)
    const currentPath = window.location.pathname;
    const authPages = ['/admin/login', '/admin/lupa-password', '/admin/reset-password'];
    
    if (authPages.includes(currentPath)) {
        // Jika sudah login dan mencoba akses halaman login, redirect ke dashboard
        const isLoggedIn = localStorage.getItem('adminLoggedIn');
        if (isLoggedIn === 'true') {
            window.location.href = '/admin';
        }
        return;
    }
    
    // Untuk halaman admin lainnya, cek apakah sudah login
    const isLoggedIn = localStorage.getItem('adminLoggedIn');
    const token = localStorage.getItem('admin_token');
    
    if (!isLoggedIn || !token) {
        // Belum login, redirect ke login
        localStorage.removeItem('adminLoggedIn');
        localStorage.removeItem('admin_token');
        localStorage.removeItem('admin_user');
        window.location.href = '/admin/login';
    }
})();
