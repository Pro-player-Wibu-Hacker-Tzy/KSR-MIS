// backend/routes.js

const express = require("express");

const {
  inventaris,
  kerjasama,
  infoLomba,
  informasi,
  reportPosko
} = require("./data");

const router = express.Router();


// =====================================================
// INVENTARIS
// =====================================================

// GET semua inventaris
router.get("/inventaris", (req, res) => {
  res.json(inventaris);
});


// GET inventaris berdasarkan ID
router.get("/inventaris/:id", (req, res) => {
  const id = Number(req.params.id);

  const item = inventaris.find((data) => data.id === id);

  if (!item) {
    return res.status(404).json({
      message: "Data inventaris tidak ditemukan"
    });
  }

  res.json(item);
});


// POST tambah inventaris
router.post("/inventaris", (req, res) => {
  const { nama, jumlah, kondisi, status } = req.body;

  if (!nama || jumlah === undefined) {
    return res.status(400).json({
      message: "Nama dan jumlah wajib diisi"
    });
  }

  const newItem = {
    id: inventaris.length > 0
      ? inventaris[inventaris.length - 1].id + 1
      : 1,
    nama,
    jumlah,
    kondisi: kondisi || "Baik",
    status: status || "Tersedia"
  };

  inventaris.push(newItem);

  res.status(201).json({
    message: "Inventaris berhasil ditambahkan",
    data: newItem
  });
});


// PUT update inventaris
router.put("/inventaris/:id", (req, res) => {
  const id = Number(req.params.id);

  const index = inventaris.findIndex(
    (data) => data.id === id
  );

  if (index === -1) {
    return res.status(404).json({
      message: "Data inventaris tidak ditemukan"
    });
  }

  inventaris[index] = {
    ...inventaris[index],
    ...req.body,
    id
  };

  res.json({
    message: "Inventaris berhasil diperbarui",
    data: inventaris[index]
  });
});


// DELETE inventaris
router.delete("/inventaris/:id", (req, res) => {
  const id = Number(req.params.id);

  const index = inventaris.findIndex(
    (data) => data.id === id
  );

  if (index === -1) {
    return res.status(404).json({
      message: "Data inventaris tidak ditemukan"
    });
  }

  const deletedItem = inventaris.splice(index, 1);

  res.json({
    message: "Inventaris berhasil dihapus",
    data: deletedItem[0]
  });
});


// =====================================================
// KERJA SAMA
// =====================================================

router.get("/kerjasama", (req, res) => {
  res.json(kerjasama);
});


router.get("/kerjasama/:id", (req, res) => {
  const id = Number(req.params.id);

  const data = kerjasama.find((item) => item.id === id);

  if (!data) {
    return res.status(404).json({
      message: "Data kerja sama tidak ditemukan"
    });
  }

  res.json(data);
});


router.post("/kerjasama", (req, res) => {
  const {
    namaInstansi,
    jenisKerjasama,
    tanggal,
    status
  } = req.body;

  if (!namaInstansi || !jenisKerjasama) {
    return res.status(400).json({
      message: "Nama instansi dan jenis kerja sama wajib diisi"
    });
  }

  const newData = {
    id: kerjasama.length > 0
      ? kerjasama[kerjasama.length - 1].id + 1
      : 1,
    namaInstansi,
    jenisKerjasama,
    tanggal: tanggal || "",
    status: status || "Aktif"
  };

  kerjasama.push(newData);

  res.status(201).json({
    message: "Data kerja sama berhasil ditambahkan",
    data: newData
  });
});


router.put("/kerjasama/:id", (req, res) => {
  const id = Number(req.params.id);

  const index = kerjasama.findIndex(
    (item) => item.id === id
  );

  if (index === -1) {
    return res.status(404).json({
      message: "Data kerja sama tidak ditemukan"
    });
  }

  kerjasama[index] = {
    ...kerjasama[index],
    ...req.body,
    id
  };

  res.json({
    message: "Data kerja sama berhasil diperbarui",
    data: kerjasama[index]
  });
});


router.delete("/kerjasama/:id", (req, res) => {
  const id = Number(req.params.id);

  const index = kerjasama.findIndex(
    (item) => item.id === id
  );

  if (index === -1) {
    return res.status(404).json({
      message: "Data kerja sama tidak ditemukan"
    });
  }

  const deletedData = kerjasama.splice(index, 1);

  res.json({
    message: "Data kerja sama berhasil dihapus",
    data: deletedData[0]
  });
});


// =====================================================
// INFO LOMBA
// =====================================================

router.get("/info-lomba", (req, res) => {
  res.json(infoLomba);
});


router.get("/info-lomba/:id", (req, res) => {
  const id = Number(req.params.id);

  const data = infoLomba.find((item) => item.id === id);

  if (!data) {
    return res.status(404).json({
      message: "Info lomba tidak ditemukan"
    });
  }

  res.json(data);
});


router.post("/info-lomba", (req, res) => {
  const {
    namaLomba,
    penyelenggara,
    tanggal,
    lokasi,
    status
  } = req.body;

  if (!namaLomba || !penyelenggara) {
    return res.status(400).json({
      message: "Nama lomba dan penyelenggara wajib diisi"
    });
  }

  const newData = {
    id: infoLomba.length > 0
      ? infoLomba[infoLomba.length - 1].id + 1
      : 1,
    namaLomba,
    penyelenggara,
    tanggal: tanggal || "",
    lokasi: lokasi || "",
    status: status || "Akan Datang"
  };

  infoLomba.push(newData);

  res.status(201).json({
    message: "Info lomba berhasil ditambahkan",
    data: newData
  });
});


router.put("/info-lomba/:id", (req, res) => {
  const id = Number(req.params.id);

  const index = infoLomba.findIndex(
    (item) => item.id === id
  );

  if (index === -1) {
    return res.status(404).json({
      message: "Info lomba tidak ditemukan"
    });
  }

  infoLomba[index] = {
    ...infoLomba[index],
    ...req.body,
    id
  };

  res.json({
    message: "Info lomba berhasil diperbarui",
    data: infoLomba[index]
  });
});


router.delete("/info-lomba/:id", (req, res) => {
  const id = Number(req.params.id);

  const index = infoLomba.findIndex(
    (item) => item.id === id
  );

  if (index === -1) {
    return res.status(404).json({
      message: "Info lomba tidak ditemukan"
    });
  }

  const deletedData = infoLomba.splice(index, 1);

  res.json({
    message: "Info lomba berhasil dihapus",
    data: deletedData[0]
  });
});


// =====================================================
// INFORMASI
// =====================================================

router.get("/informasi", (req, res) => {
  res.json(informasi);
});


router.get("/informasi/:id", (req, res) => {
  const id = Number(req.params.id);

  const data = informasi.find((item) => item.id === id);

  if (!data) {
    return res.status(404).json({
      message: "Informasi tidak ditemukan"
    });
  }

  res.json(data);
});


router.post("/informasi", (req, res) => {
  const {
    judul,
    isi,
    tanggal,
    kategori
  } = req.body;

  if (!judul || !isi) {
    return res.status(400).json({
      message: "Judul dan isi informasi wajib diisi"
    });
  }

  const newData = {
    id: informasi.length > 0
      ? informasi[informasi.length - 1].id + 1
      : 1,
    judul,
    isi,
    tanggal: tanggal || "",
    kategori: kategori || "Umum"
  };

  informasi.push(newData);

  res.status(201).json({
    message: "Informasi berhasil ditambahkan",
    data: newData
  });
});


router.put("/informasi/:id", (req, res) => {
  const id = Number(req.params.id);

  const index = informasi.findIndex(
    (item) => item.id === id
  );

  if (index === -1) {
    return res.status(404).json({
      message: "Informasi tidak ditemukan"
    });
  }

  informasi[index] = {
    ...informasi[index],
    ...req.body,
    id
  };

  res.json({
    message: "Informasi berhasil diperbarui",
    data: informasi[index]
  });
});


router.delete("/informasi/:id", (req, res) => {
  const id = Number(req.params.id);

  const index = informasi.findIndex(
    (item) => item.id === id
  );

  if (index === -1) {
    return res.status(404).json({
      message: "Informasi tidak ditemukan"
    });
  }

  const deletedData = informasi.splice(index, 1);

  res.json({
    message: "Informasi berhasil dihapus",
    data: deletedData[0]
  });
});


// =====================================================
// REPORT POSKO
// =====================================================

router.get("/report-posko", (req, res) => {
  res.json(reportPosko);
});


router.get("/report-posko/:id", (req, res) => {
  const id = Number(req.params.id);

  const data = reportPosko.find((item) => item.id === id);

  if (!data) {
    return res.status(404).json({
      message: "Report posko tidak ditemukan"
    });
  }

  res.json(data);
});


router.post("/report-posko", (req, res) => {
  const {
    namaPosko,
    lokasi,
    tanggal,
    jumlahPetugas,
    kondisi,
    keterangan
  } = req.body;

  if (!namaPosko || !lokasi) {
    return res.status(400).json({
      message: "Nama posko dan lokasi wajib diisi"
    });
  }

  const newData = {
    id: reportPosko.length > 0
      ? reportPosko[reportPosko.length - 1].id + 1
      : 1,
    namaPosko,
    lokasi,
    tanggal: tanggal || "",
    jumlahPetugas: jumlahPetugas || 0,
    kondisi: kondisi || "Aman",
    keterangan: keterangan || ""
  };

  reportPosko.push(newData);

  res.status(201).json({
    message: "Report posko berhasil ditambahkan",
    data: newData
  });
});


router.put("/report-posko/:id", (req, res) => {
  const id = Number(req.params.id);

  const index = reportPosko.findIndex(
    (item) => item.id === id
  );

  if (index === -1) {
    return res.status(404).json({
      message: "Report posko tidak ditemukan"
    });
  }

  reportPosko[index] = {
    ...reportPosko[index],
    ...req.body,
    id
  };

  res.json({
    message: "Report posko berhasil diperbarui",
    data: reportPosko[index]
  });
});


router.delete("/report-posko/:id", (req, res) => {
  const id = Number(req.params.id);

  const index = reportPosko.findIndex(
    (item) => item.id === id
  );

  if (index === -1) {
    return res.status(404).json({
      message: "Report posko tidak ditemukan"
    });
  }

  const deletedData = reportPosko.splice(index, 1);

  res.json({
    message: "Report posko berhasil dihapus",
    data: deletedData[0]
  });
});


module.exports = router;