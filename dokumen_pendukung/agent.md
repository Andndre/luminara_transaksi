# **Laravel Fullstack (Backend + Frontend)**

**Landing Page & Booking System – Luminara Photobooth**

---

## 1. KONTEKS PROJECT

Project ini adalah **Laravel Fullstack** (satu repo untuk backend & frontend).

- Framework: **Laravel**
- Frontend **dibangun di dalam Laravel**
    - Blade + Tailwind **ATAU**
    - Inertia + Vue/React (pilih salah satu, konsisten)

- Repository existing: `luminara_transaksi`

Catatan penting:

- Project **pernah dibuat untuk Midtrans**
- Midtrans **TIDAK DIGUNAKAN**
- Kode & endpoint Midtrans **JANGAN DIHAPUS**
- Booking dan pembayaran menggunakan **manual transfer**
- Endpoint booking **berbeda** dengan Midtrans → aman

---

## 2. TUJUAN SISTEM

Membangun **Landing Page + Booking System** dalam satu aplikasi Laravel dengan alur:

```
Landing Page
→ Pilih Paket
→ Pilih Tanggal (Kalender)
→ Isi Detail Pemesan
→ Simpan ke Database
→ Redirect WhatsApp Admin
→ Admin mengatur status pembayaran
```

Sistem harus:

- Fullstack Laravel
- UX sederhana & jelas
- Aman dari double booking

---

## 3. STATUS BOOKING (FINAL – WAJIB)

Gunakan **ENUM berikut, TIDAK BOLEH DIUBAH:**

```text
PENDING
DP_DIBAYAR
LUNAS
DIBATALKAN
```

---

## 4. ATURAN BISNIS (WAJIB)

### 4.1 Kuota Booking

- Maksimal **4 booking per tanggal**
- Booking dihitung jika `status != DIBATALKAN`
- Jika booking ≥ 4 → tanggal **PENUH**
- Tanggal tertentu bisa:
    - `BLOCKED` → tidak menerima booking sama sekali

---

### 4.2 Pembayaran

- Tidak ada payment gateway
- Pembayaran manual (transfer)
- Sistem hanya mencatat status:
    - `DP_DIBAYAR`
    - `LUNAS`

- Jika user batal / tidak bayar → `DIBATALKAN`

---

## 5. STRUKTUR DATABASE (WAJIB)

### 5.1 Tabel `bookings`

```php
id (uuid / bigint)
package_id
package_name
package_type            // photobooth | videobooth360 | combo
duration_hours
price_total
payment_type            // DP | LUNAS | NONE
event_date (date)
event_location
event_type
customer_name
customer_phone
customer_email
notes
status                  // PENDING | DP_DIBAYAR | LUNAS | DIBATALKAN
created_at
updated_at
```

---

### 5.2 Tabel `blocked_dates` (REKOMENDASI)

```php
date (date, unique)
reason (nullable)
```

---

## 6. ROUTE & CONTROLLER (LARAVEL)

### 6.1 Public Routes

```php
GET  /                  // landing page
GET  /booking           // booking page
POST /booking           // submit booking
GET  /calendar/availability
```

---

### 6.2 Admin Routes

```php
GET   /admin/bookings
PATCH /admin/bookings/{id}/status
```

---

## 7. FRONTEND (DALAM LARAVEL)

### 7.1 Landing Page

- Hero + CTA **“Booking Sekarang”**
- Section:
    - Produk (Photobooth / Videobooth 360 / Combo)
    - Keunggulan
    - Cara Booking
    - CTA

---

### 7.2 Booking Page (Multi-Step Form)

#### Step 1 – Pilih Paket

- Paket
- Durasi
- Harga otomatis

---

#### Step 2 – Pilih Tanggal (KALENDER WAJIB)

Kalender harus:

- Menampilkan **jumlah booking per tanggal**
- Status warna
- Disable jika penuh / blocked

##### Status Kalender:

| Kondisi     | Label          | Aksi         |
| ----------- | -------------- | ------------ |
| 0 booking   | Tersedia       | Bisa dipilih |
| 1–3 booking | Hampir penuh   | Bisa dipilih |
| 4 booking   | Penuh          | Disabled     |
| BLOCKED     | Tidak tersedia | Disabled     |

##### Hover / Click

- **Hover (desktop)**:

    ```
    12 Mei 2026
    Booking: 3 / 4
    Status: Hampir penuh
    ```

- **Click**:
    - Jika penuh → toast error
    - Jika tersedia → pilih tanggal

---

#### Step 3 – Data Pemesan

- Nama
- WhatsApp
- Email
- Lokasi acara
- Jenis acara
- Catatan

---

#### Step 4 – Konfirmasi

- Ringkasan booking
- Submit

---

## 8. ENDPOINT AVAILABILITY (WAJIB)

### Controller Logic

```php
GET /calendar/availability?month=YYYY-MM
```

### Response JSON

```json
[
    {
        "date": "2026-05-12",
        "booking_count": 3,
        "max_booking": 4,
        "is_blocked": false
    }
]
```

---

## 9. VALIDASI BACKEND (KRITIS)

Pada `POST /booking`:

1. Query booking pada `event_date`
2. `WHERE status != 'DIBATALKAN'`
3. Jika count ≥ 4 → reject
4. Jika tanggal ada di `blocked_dates` → reject

> Frontend hanya UI, **Laravel backend adalah source of truth**

---

## 10. WHATSAPP REDIRECT (WAJIB)

Setelah booking sukses:

- Status awal: `PENDING`
- Redirect ke WhatsApp Admin

```text
https://wa.me/62XXXXXXXXXX?text=ENCODED_MESSAGE
```

### Template Pesan

```
Halo Admin Luminara 👋

Booking baru:
Nama: {{customer_name}}
Paket: {{package_name}}
Tanggal: {{event_date}}
Durasi: {{duration_hours}} jam
Lokasi: {{event_location}}
Total: Rp {{price_total}}

Status: PENDING
```

---

## 11. ADMIN PANEL (MINIMAL)

- List booking
- Filter:
    - Tanggal
    - Status

- Update status:
    - DP_DIBAYAR
    - LUNAS
    - DIBATALKAN

---

## 12. CONSTRAINT TEKNIS

- Jangan hapus Midtrans code
- Jangan aktifkan payment gateway
- Gunakan struktur Laravel existing
- Boleh tambah migration & model
- Gunakan validation & form request Laravel

---

## 13. OUTPUT WAJIB

- Landing page Laravel
- Booking page dengan kalender interaktif
- Data tersimpan ke DB
- WhatsApp redirect berjalan
- Admin bisa ubah status
- Tidak ada double booking

---

## 14. PRIORITAS IMPLEMENTASI

1. Validasi kuota backend
2. Kalender informatif
3. UX booking sederhana
4. Struktur Laravel rapi
