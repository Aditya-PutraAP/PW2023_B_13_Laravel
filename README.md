# UAS Pemrograman Web Gasal 2023/2024

## Kelas B Kelompok 13

### Anggota Kelompok

-   Agustinus Aditya Putra Pratama (210711429) Backend (admin dan user, auth (login & register), sama kredit)
-   Christopher Hartono (210711011) Frontend dan integrasi
-   Daniel Natalius Christopper (210711346) backend pembayaran

### Credential

-   Login Admin
    -   email: Admin@gmail.com
    -   password: Admin
-   Login User
    -   email: christhartono@hotmail.com
    -   password: 123321

### Bonus yang diambil

-   Routes API

    ```
    All ----------------
    POST      api/register (membuat user baru)
    POST      api/login (untuk login)

    ADMIN ---------------
    GET|HEAD  api/rekening (mengambil list rekening)
    POST      api/rekening (membuat rekening baru)
    GET|HEAD  api/rekening/{id} (mengambil rekening berdasarkan id)
    PUT       api/rekening/{id}  (mengubah rekening berdasarkan id)
    DELETE    api/rekening/{id} (menghapus/menutup rekening berdasarkan id)
    GET|HEAD  api/kredit (untuk mengambil kredit yang masih pending untuk admin)
    POST      api/kredit/{id} (untuk mengubah status kredit)

    USER -----------
    GET|HEAD  api/kredit/{id} (untuk mengambil kredit berdasarkan id)
    POST      api/kredit (untuk mengajukan kredit)
    DELETE    api/kredit/{id} (untuk menghapus kredit)
    GET|HEAD  api/pembayaran (mengambil list pembayaran token)
    POST      api/pembayaran (membuat pembayaran token)
    GET|HEAD  api/pembayaran/{id} (mengambil pembayaran token berdasarkan id_user)
    DELETE    api/pembayaran/{id} (menghapus pembayaran token berdasarkan id_user)
    GET|HEAD  api/profile (mengambil profile user)
    POST      api/profile/{id} (mengubah profile picture)
    ```

-   React frontend
    -   Link repo: [Github](https://github.com/bootloopmaster636/PW2023_B_13_React)
        https://github.com/bootloopmaster636/PW2023_B_13_React

Berikut link backend, untuk jaga2
https://github.com/Aditya-PutraAP/PW2023_B_13_Laravel
