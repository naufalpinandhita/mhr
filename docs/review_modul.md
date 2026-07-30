# Dokumentasi Fungsional Modul Review & Katalog Anime

Dokumen ini menjelaskan alur dan kemampuan fungsional dari modul **Katalog Anime** serta modul **Ulasan & Rating**.

---

## 1. Modul Katalog Anime (AniList Integration)

Modul Katalog Anime berfungsi untuk menyediakan data anime terkini tanpa memerlukan input data anime secara manual.

### Fitur Utama:
- **Daftar Anime Populer/Trending**: Menampilkan daftar anime yang sedang populer atau banyak dibicarakan.
- **Pencarian Anime**: Memungkinkan pengguna mencari anime berdasarkan kata kunci atau judul.
- **Detail Anime**: Menampilkan informasi rinci mengenai suatu anime, meliputi:
  - Judul anime (berbagai format bahasa)
  - Gambar sampul (cover) dan poster banner
  - Sinopsis dan genre
  - Jumlah episode dan durasi per episode
  - Musim dan tahun rilis
  - Informasi staf pembuat dan daftar karakter utama

---

## 2. Modul Ulasan & Rating

Modul Ulasan & Rating memberikan fasilitas bagi pengguna terdaftar untuk memberikan penilaian serta ulasan pada anime yang ada di katalog.

### Fitur Utama:
- **Penilaian (Rating)**:
  - Pengguna dapat memberikan nilai rating dalam skala **1 sampai 10** (integer).
- **Penulisan Ulasan (Review Text)**:
  - Pengguna dapat menulis ulasan teks mengenai pendapat mereka tentang anime tersebut (panjang ulasan antara 10 hingga 200 karakter).
- **Aturan 1 Pengguna 1 Ulasan**:
  - Setiap pengguna hanya diperbolehkan memiliki **1 ulasan per anime**.
  - Jika pengguna menulis ulasan baru pada anime yang sama, ulasan sebelumnya akan diperbarui (*update*) secara otomatis.
- **Membaca Ulasan**:
  - Pengguna dapat membaca ulasan yang ditulis oleh pengguna lain untuk setiap anime.
  - Setiap ulasan menampilkan nama penulisknya, foto profil, rating yang diberikan, teks ulasan, serta waktu penulisan.
- **Ringkasan Rating**:
  - Menghitung dan menampilkan total ulasan serta rata-rata nilai rating dari seluruh ulasan pengguna untuk anime terkait.
- **Penghapusan Ulasan**:
  - Pengguna dapat menghapus ulasan milik mereka sendiri.
  - Pengurus sistem (Admin) memiliki kewenangan untuk menghapus ulasan pengguna lain jika diperlukan.
