# KSR-MIS API Contract

## Backend

Base URL:

http://localhost:3000

## Inventaris

GET /api/inventaris

POST /api/inventaris

PUT /api/inventaris/:id

DELETE /api/inventaris/:id

Field:

- id
- nama
- jumlah
- kondisi
- status

## Kerja Sama

GET /api/kerjasama

POST /api/kerjasama

PUT /api/kerjasama/:id

DELETE /api/kerjasama/:id

Field:

- id
- namaInstansi
- jenisKerjasama
- tanggal
- status

## Info Lomba

GET /api/info-lomba

POST /api/info-lomba

PUT /api/info-lomba/:id

DELETE /api/info-lomba/:id

Field:

- id
- namaLomba
- penyelenggara
- tanggal
- lokasi
- status

## Informasi

GET /api/informasi

POST /api/informasi

PUT /api/informasi/:id

DELETE /api/informasi/:id

Field:

- id
- judul
- isi
- tanggal
- kategori

## Report Posko

GET /api/report-posko

POST /api/report-posko

PUT /api/report-posko/:id

DELETE /api/report-posko/:id

Field:

- id
- namaPosko
- lokasi
- tanggal
- jumlahPetugas
- kondisi
- keterangan