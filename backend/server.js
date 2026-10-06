// backend/server.js

const express = require("express");
const cors = require("cors");

const routes = require("./routes");

const app = express();


// ========================================
// MIDDLEWARE
// ========================================

// Mengizinkan frontend mengakses backend
app.use(cors());

// Membaca data JSON dari request
app.use(express.json());


// ========================================
// ROUTES
// ========================================

// Semua API menggunakan prefix /api
app.use("/api", routes);


// ========================================
// HOME / TEST SERVER
// ========================================

app.get("/", (req, res) => {
  res.json({
    message: "Backend KSR-MIS berhasil berjalan",
    status: "OK"
  });
});


// ========================================
// 404
// ========================================

app.use((req, res) => {
  res.status(404).json({
    message: "Endpoint tidak ditemukan"
  });
});


// ========================================
// SERVER
// ========================================

const PORT = 3000;

app.listen(PORT, () => {
  console.log(`
========================================
   KSR-MIS BACKEND
========================================

Server berjalan di:
http://localhost:${PORT}

API:
GET http://localhost:${PORT}/api/inventaris
GET http://localhost:${PORT}/api/kerjasama
GET http://localhost:${PORT}/api/info-lomba
GET http://localhost:${PORT}/api/informasi
GET http://localhost:${PORT}/api/report-posko

========================================
  `);
});