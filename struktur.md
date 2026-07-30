mhr/
├── api/
│   ├── config/
│   │   ├── app.php           # session, BASE_URL, autoload
│   │   └── database.php      # PDO connection singleton
│   ├── controllers/
│   │   └── AuthController.php # register(), login(), logout()
│   ├── models/
│   │   └── User.php          # find, create, update, verify password
│   ├── middleware/
│   │   └── AuthMiddleware.php # requireAuth(), requireGuest(), requireAdmin()
│   └── helpers/
│       └── functions.php     # redirect(), flash messages, CSRF, dll
├── database/
│   └── schema.sql            # DDL lengkap (7 tabel)
├── public/                   # ↓ ENTRY POINT — semua akses dari sini
│   ├── index.php             # Beranda
│   ├── register.php          # Form daftar
│   ├── register_process.php  # POST handler daftar
│   ├── login.php             # Form login
│   ├── login_process.php     # POST handler login
│   ├── logout.php            # Logout
│   ├── profile.php           # Halaman profil user
│   └── css/
│       └── style.css         # Dark theme
└── views/
    ├── layouts/main.php      # Template utama
    └── partials/
        ├── header.php        # Navbar
        ├── footer.php        # Footer
        └── flash.php         # Flash messages
