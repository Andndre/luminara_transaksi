# Rencana Fitur: Undangan Digital (Digital Invitations)

## 1. Gambaran Umum
Fitur ini bertujuan untuk memungkinkan admin membuat dan mengelola undangan pernikahan digital secara langsung dari dashboard. Admin dapat memilih template (custom) dan menghasilkan tautan unik untuk setiap pasangan pengantin.

## 2. Struktur Database (Usulan)
Kita akan membutuhkan tabel baru untuk menyimpan data undangan.

### Tabel: `invitations`
Menyimpan data inti undangan.
*   `id`: Primary Key
*   `slug`: String, Unique (untuk URL publik, misal: `domain.com/invitation/romeo-juliet`)
*   `template_name`: String (identitas template yang dipilih, misal: `ocean_blue`, `rustic_gold`)
*   `groom_name`: String (Nama Pria)
*   `bride_name`: String (Nama Wanita)
*   `event_date`: DateTime (Tanggal & Waktu Acara)
*   `venue_name`: String (Nama Lokasi)
*   `venue_address`: Text (Alamat Lengkap)
*   `map_link`: String (Link Google Maps)
*   `is_active`: Boolean (Status aktif/tidak)
*   `created_at`, `updated_at`

*(Opsional: Tabel `invitation_galleries` jika ingin galeri foto pre-wedding terpisah dari galeri utama sistem)*

## 3. Alur Pengguna (Admin Flow)

### A. Halaman Daftar Undangan (Index)
*   Lokasi: Menu Sidebar > "Undangan Digital"
*   Isi: Tabel daftar event pernikahan yang sudah dibuat (Nama Mempelai, Tanggal, Status, Link).
*   Aksi: Tombol **"Buat Undangan"**.

### B. Tahap Pembuatan (Wizard)
1.  **Klik "Buat Undangan"**:
    *   Admin diarahkan ke halaman pemilihan template.
2.  **Pilih Template**:
    *   Tampilan grid yang menampilkan *thumbnail* dari desain-desain undangan yang tersedia.
    *   Admin memilih satu template.
3.  **Input Data**:
    *   Formulir untuk mengisi data mempelai, tanggal, lokasi, dll.
4.  **Simpan & Publish**:
    *   Sistem men-generate URL unik.
    *   Undangan siap diakses.

## 4. Arsitektur Teknis

### Routes
**Admin:**
*   `GET /admin/invitations` (Index)
*   `GET /admin/invitations/create` (Pilih Template)
*   `POST /admin/invitations` (Store data)
*   `GET /admin/invitations/{id}/edit` (Edit data)
*   `PUT /admin/invitations/{id}` (Update)
*   `DELETE /admin/invitations/{id}` (Hapus)

**Public:**
*   `GET /invitation/{slug}` (Halaman undangan publik)

### Controller
*   `App\Http\Controllers\Admin\InvitationController`
*   `App\Http\Controllers\PublicInvitationController` (Untuk menangani render view template publik)

### Views
**Admin Panel:**
*   `resources/views/admin/invitations/index.blade.php`
*   `resources/views/admin/invitations/select-template.blade.php`
*   `resources/views/admin/invitations/form.blade.php`

**Public Themes (Custom Templates):**
*   `resources/views/themes/rustic/index.blade.php`
*   `resources/views/themes/elegant/index.blade.php`
*   *(Struktur folder themes bisa disesuaikan agar modular)*

## 5. Langkah Pengerjaan Selanjutnya
Sesuai instruksi, tahap selanjutnya adalah:
1.  Membuat **Migration** untuk tabel `invitations`.
2.  Membuat **Model** `Invitation`.
3.  Menambahkan menu di **Sidebar Admin**.
4.  Membuat **Controller** dan **Route** dasar.
5.  Implementasi halaman **Pilih Template**.
