## Login API

### Endpoint
`POST {{base_url}}/auth/login`

### Deskripsi
Endpoint ini digunakan untuk otentikasi pengguna dengan menggunakan **username** dan **password**. Jika kredensial valid, server akan mengembalikan informasi pengguna dan token akses.

---

### Request

#### Header
| Key           | Value             |
|---------------|-------------------|
| Content-Type  | application/json  |

#### Body
```json
{
    "username": "sschambergerss",
    "password": "password"
}
```

---

### Response

#### 1. **Berhasil**
**Status Code**: `200 OK`

**Contoh Respons**:
```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": null
    },
    "data": {
        "id": 2,
        "name": "Ms. Lois Nikolaus",
        "email": "eldridge.blick@example.org",
        "username": "sschamberger",
        "phone": "669-597-8567",
        "region": "Cuba",
        "photo_profile": "user-default.png",
        "created_at": "2024-11-23T08:25:30.000000Z",
        "updated_at": "2024-11-23T08:25:30.000000Z",
        "token": "23|nbiZftbtLsrRyfCcbpD4486CYeTYhUVUZU530f5X47573890"
    }
}
```

**Penjelasan**:
- `meta`: Berisi metadata dari respons.
  - `code`: Status kode HTTP.
  - `status`: Status hasil operasi (`success` atau `error`).
  - `message`: Pesan tambahan (opsional, dapat berupa `null`).
- `data`: Informasi pengguna yang berhasil login.
  - `id`: ID unik pengguna.
  - `name`: Nama lengkap pengguna.
  - `email`: Email pengguna.
  - `username`: Username pengguna.
  - `phone`: Nomor telepon pengguna.
  - `region`: Wilayah pengguna.
  - `photo_profile`: Nama file foto profil (default: `user-default.png`).
  - `created_at`: Waktu pembuatan akun.
  - `updated_at`: Waktu terakhir akun diperbarui.
  - `token`: Token autentikasi untuk akses ke endpoint yang dilindungi.

---

#### 2. **Gagal: Username/Password Salah**
**Status Code**: `400 Bad Request`

**Contoh Respons**:
```json
{
    "meta": {
        "code": 400,
        "status": "error",
        "message": null
    },
    "data": "No query results for model [App\\Models\\User]."
}
```

**Penjelasan**:
- `meta`: Metadata dari respons.
  - `code`: Status kode HTTP.
  - `status`: Status hasil operasi (`error`).
  - `message`: Pesan tambahan (opsional, dapat berupa `null`).
- `data`: Menyediakan informasi kesalahan, dalam hal ini menunjukkan bahwa pengguna tidak ditemukan.

---

### Catatan
- Pastikan untuk menggunakan **token** yang diterima dalam respons berhasil untuk mengakses endpoint yang dilindungi.
- Jika kredensial salah, server akan merespons dengan kode status `400` dan pesan kesalahan.

---

## Register API

### Endpoint
`POST {{base_url}}/auth/register`

### Deskripsi
Endpoint ini digunakan untuk mendaftarkan pengguna baru dengan memberikan informasi yang diperlukan seperti nama, email, username, password, nomor telepon, wilayah, dan (opsional) foto profil.

---

### Request

#### Header
| Key           | Value             |
|---------------|-------------------|
| Content-Type  | application/json  |

#### Body
```json
{
    "name": "Sophia Williams",
    "email": "sophia.williams@example.com",
    "username": "sophia_w",
    "password": "Sophia123!",
    "phone": "081198765432",
    "region": "Yogyakarta", 
    "photo_profile": "optional-image.png"
}
```

> **Catatan**: 
> - **`photo_profile`** boleh dikosongkan. Jika kosong, server akan menggunakan nilai default (`user-default.png`).

---

### Response

#### 1. **Berhasil**
**Status Code**: `200 OK`

**Contoh Respons**:
```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": "Register success"
    },
    "data": {
        "name": "Sophia Williamss",
        "email": "sophia.williamssa@example.com",
        "username": "sophia_dw",
        "phone": "081198765432",
        "region": "Yogyakarta",
        "updated_at": "2024-11-23T16:00:55.000000Z",
        "created_at": "2024-11-23T16:00:55.000000Z",
        "id": 15,
        "token": "24|yQBVaHIcESLGGb36DBTjH38tooe17qmaFkCCgxAeacb13ce7"
    }
}
```

**Penjelasan**:
- `meta`: Metadata dari respons.
  - `code`: Status kode HTTP.
  - `status`: Status hasil operasi (`success`).
  - `message`: Pesan tambahan untuk menggambarkan hasil operasi.
- `data`: Informasi pengguna yang baru saja terdaftar.
  - `name`: Nama lengkap pengguna.
  - `email`: Email pengguna.
  - `username`: Username pengguna.
  - `phone`: Nomor telepon pengguna.
  - `region`: Wilayah pengguna.
  - `created_at`: Waktu pembuatan akun.
  - `updated_at`: Waktu terakhir akun diperbarui.
  - `id`: ID unik pengguna.
  - `token`: Token autentikasi untuk akses ke endpoint yang dilindungi.

---

#### 2. **Gagal: Data Dobel**
**Status Code**: `422 Unprocessable Entity`

**Contoh Respons**:
```json
{
    "message": "The email has already been taken. (and 1 more error)",
    "errors": {
        "email": [
            "The email has already been taken."
        ],
        "username": [
            "The username has already been taken."
        ]
    }
}
```

**Penjelasan**:
- `message`: Deskripsi kesalahan secara umum.
- `errors`: Daftar kesalahan yang lebih spesifik.
  - `email`: Menyatakan bahwa email yang dimasukkan sudah digunakan oleh pengguna lain.
  - `username`: Menyatakan bahwa username yang dimasukkan sudah digunakan oleh pengguna lain.

---

### Catatan
- Pastikan **email** dan **username** bersifat unik.
- Gunakan **token** yang diterima pada respons berhasil untuk mengakses endpoint lain yang membutuhkan autentikasi.
- Validasi di sisi klien disarankan untuk menghindari pengiriman data duplikat sebelum request dikirim ke server.

---

## Logout API

### Endpoint
`POST {{base_url}}/auth/logout`

### Deskripsi
Endpoint ini digunakan untuk keluar dari sesi pengguna yang sedang login. Logout akan membatalkan token autentikasi yang digunakan.

---

### Request

#### Header
| Key           | Value                |
|---------------|----------------------|
| Authorization | Bearer `<token>`    |
| Content-Type  | application/json     |

> **Catatan**: Pastikan untuk menyertakan **Bearer Token** yang valid dalam header **Authorization**.

#### Body
Tidak diperlukan.

---

### Response

#### 1. **Berhasil**
**Status Code**: `200 OK`

**Contoh Respons**:
```json
{
    "meta": {
        "code": 200,
        "status": "success",
        "message": "Logout success"
    },
    "data": null
}
```

**Penjelasan**:
- `meta`: Metadata dari respons.
  - `code`: Status kode HTTP.
  - `status`: Status hasil operasi (`success`).
  - `message`: Pesan konfirmasi bahwa logout berhasil.
- `data`: Berisi `null`, karena tidak ada data tambahan yang diperlukan untuk respons logout.

---

#### 2. **Gagal: Token Tidak Valid atau Tidak Disertakan**
**Status Code**: `401 Unauthorized`

**Contoh Respons**:
```json
{
    "message": "Unauthenticated."
}
```

**Penjelasan**:
- `message`: Pesan kesalahan yang menunjukkan bahwa pengguna tidak diautentikasi. Ini terjadi jika token tidak valid, kadaluwarsa, atau tidak disertakan dalam permintaan.

---

### Catatan
- Pastikan untuk menggunakan **Bearer Token** yang valid saat melakukan logout.
- Setelah logout berhasil, token yang digunakan akan menjadi tidak valid dan tidak dapat digunakan untuk mengakses endpoint lain.
- Jika mencoba mengakses endpoint yang membutuhkan autentikasi setelah logout, server akan merespons dengan pesan **"Unauthenticated."**
