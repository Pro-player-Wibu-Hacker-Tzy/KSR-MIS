// backend/data.js

// ================================
// DATA INVENTARIS
// ================================
const inventaris = [
  {
    id: 1,
    nama: "Kotak P3K",
    jumlah: 5,
    kondisi: "Baik",
    status: "Tersedia"
  },
  {
    id: 2,
    nama: "Tandu",
    jumlah: 2,
    kondisi: "Baik",
    status: "Tersedia"
  },
  {
    id: 3,
    nama: "Tabung Oksigen",
    jumlah: 1,
    kondisi: "Baik",
    status: "Dipinjam"
  },
  {
    id: 4,
    nama: "Seragam PMI",
    jumlah: 10,
    kondisi: "Baik",
    status: "Tersedia"
  }
];


// ================================
// DATA KERJA SAMA
// ================================
const kerjasama = [
  {
    id: 1,
    namaInstansi: "PMI Kota Malang",
    jenisKerjasama: "Kegiatan Sosial",
    tanggal: "2026-10-10",
    status: "Aktif"
  },
  {
    id: 2,
    namaInstansi: "Universitas Muhammadiyah Malang",
    jenisKerjasama: "Kegiatan Kampus",
    tanggal: "2026-10-15",
    status: "Aktif"
  }
];


// ================================
// DATA INFO LOMBA
// ================================
const infoLomba = [
  {
    id: 1,
    namaLomba: "Lomba Pertolongan Pertama",
    penyelenggara: "PMI Jawa Timur",
    tanggal: "2026-11-01",
    lokasi: "Surabaya",
    status: "Akan Datang"
  },
  {
    id: 2,
    namaLomba: "Lomba Kepalangmerahan",
    penyelenggara: "PMI Kota Malang",
    tanggal: "2026-11-15",
    lokasi: "Malang",
    status: "Akan Datang"
  }
];


// ================================
// DATA INFORMASI
// ================================
const informasi = [
  {
    id: 1,
    judul: "Pelatihan Pertolongan Pertama",
    isi: "Pelatihan dasar pertolongan pertama untuk anggota KSR.",
    tanggal: "2026-10-05",
    kategori: "Pelatihan"
  },
  {
    id: 2,
    judul: "Rapat Anggota KSR",
    isi: "Rapat koordinasi anggota KSR untuk persiapan kegiatan.",
    tanggal: "2026-10-08",
    kategori: "Kegiatan"
  }
];


// ================================
// DATA REPORT POSKO
// ================================
const reportPosko = [
  {
    id: 1,
    namaPosko: "Posko Kampus",
    lokasi: "Universitas Muhammadiyah Malang",
    tanggal: "2026-10-05",
    jumlahPetugas: 5,
    kondisi: "Aman",
    keterangan: "Kegiatan berjalan dengan baik."
  },
  {
    id: 2,
    namaPosko: "Posko Kegiatan Mahasiswa",
    lokasi: "Lapangan UMM",
    tanggal: "2026-10-06",
    jumlahPetugas: 4,
    kondisi: "Aman",
    keterangan: "Tidak terdapat kejadian khusus."
  }
];


// ================================
// EXPORT DATA
// ================================

module.exports = {
  inventaris,
  kerjasama,
  infoLomba,
  informasi,
  reportPosko
};