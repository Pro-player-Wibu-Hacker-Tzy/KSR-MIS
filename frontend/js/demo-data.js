(function () {
    const demoData = {
        inventaris: [
            { id: 1, nama: "Kotak P3K", jumlah: 5, kondisi: "Baik", status: "Tersedia" },
            { id: 2, nama: "Tandu Lipat", jumlah: 2, kondisi: "Baik", status: "Tersedia" },
            { id: 3, nama: "Tabung Oksigen", jumlah: 1, kondisi: "Baik", status: "Dipinjam" },
            { id: 4, nama: "Seragam PMI", jumlah: 10, kondisi: "Baik", status: "Tersedia" },
            { id: 5, nama: "Tensimeter", jumlah: 3, kondisi: "Baik", status: "Tersedia" },
            { id: 6, nama: "Radio Komunikasi", jumlah: 4, kondisi: "Rusak Ringan", status: "Tersedia" }
        ],
        kerjasama: [
            { id: 1, namaInstansi: "PMI Kota Malang", jenisKerjasama: "Kegiatan Sosial", tanggal: "2026-10-10", status: "Aktif" },
            { id: 2, namaInstansi: "Universitas Muhammadiyah Malang", jenisKerjasama: "Kegiatan Kampus", tanggal: "2026-10-15", status: "Aktif" },
            { id: 3, namaInstansi: "PMI Kabupaten Malang", jenisKerjasama: "Pelatihan Relawan", tanggal: "2026-10-18", status: "Pengajuan" },
            { id: 4, namaInstansi: "Rumah Sakit UMM", jenisKerjasama: "Dukungan Medis", tanggal: "2026-09-25", status: "Selesai" }
        ],
        "info-lomba": [
            { id: 1, namaLomba: "Lomba Pertolongan Pertama", penyelenggara: "PMI Jawa Timur", tanggal: "2026-11-01", lokasi: "Surabaya", status: "Akan Datang" },
            { id: 2, namaLomba: "Lomba Kepalangmerahan", penyelenggara: "PMI Kota Malang", tanggal: "2026-11-15", lokasi: "Malang", status: "Akan Datang" },
            { id: 3, namaLomba: "Simulasi Tanggap Bencana", penyelenggara: "BPBD Kota Malang", tanggal: "2026-12-05", lokasi: "Malang", status: "Akan Datang" },
            { id: 4, namaLomba: "Kompetisi Relawan Muda", penyelenggara: "PMI Jawa Timur", tanggal: "2026-09-20", lokasi: "Sidoarjo", status: "Selesai" }
        ],
        informasi: [
            { id: 1, judul: "Pelatihan Pertolongan Pertama", isi: "Pelatihan dasar pertolongan pertama untuk anggota KSR.", tanggal: "2026-10-05", kategori: "Pelatihan" },
            { id: 2, judul: "Rapat Anggota KSR", isi: "Rapat koordinasi anggota KSR untuk persiapan kegiatan.", tanggal: "2026-10-08", kategori: "Kegiatan" },
            { id: 3, judul: "Jadwal Donor Darah", isi: "Kegiatan donor darah terbuka untuk sivitas akademika dan masyarakat umum.", tanggal: "2026-10-16", kategori: "Kegiatan" },
            { id: 4, judul: "Pendaftaran Pelatihan Relawan", isi: "Pendaftaran pelatihan lanjutan untuk anggota aktif dibuka hingga akhir bulan.", tanggal: "2026-10-19", kategori: "Pelatihan" }
        ],
        "report-posko": [
            { id: 1, namaPosko: "Posko Kampus", lokasi: "Universitas Muhammadiyah Malang", tanggal: "2026-10-05", jumlahPetugas: 5, kondisi: "Aman", keterangan: "Kegiatan berjalan dengan baik." },
            { id: 2, namaPosko: "Posko Kegiatan Mahasiswa", lokasi: "Lapangan UMM", tanggal: "2026-10-06", jumlahPetugas: 4, kondisi: "Aman", keterangan: "Tidak terdapat kejadian khusus." },
            { id: 3, namaPosko: "Posko Donor Darah", lokasi: "Auditorium UMM", tanggal: "2026-10-12", jumlahPetugas: 6, kondisi: "Perlu Perhatian", keterangan: "Perlu penambahan persediaan air minum untuk petugas." },
            { id: 4, namaPosko: "Posko Simulasi Bencana", lokasi: "Lapangan Kampus III UMM", tanggal: "2026-10-18", jumlahPetugas: 8, kondisi: "Darurat", keterangan: "Simulasi penanganan korban telah selesai dan area sudah diamankan." }
        ]
    };

    function createResponse(payload, status) {
        return {
            ok: status >= 200 && status < 300,
            status,
            json: async () => payload
        };
    }

    window.ksrDemoApiFetch = async function (input, options = {}) {
        const url = new URL(typeof input === "string" ? input : input.url, window.location.href);
        const match = url.pathname.match(/\/api\/([^/]+)(?:\/(\d+))?\/?$/);

        if (!match || !demoData[match[1]]) {
            return createResponse({ message: "Endpoint demo tidak ditemukan." }, 404);
        }

        const collection = demoData[match[1]];
        const id = match[2] ? Number(match[2]) : null;
        const method = (options.method || "GET").toUpperCase();

        if (method === "GET" && id === null) {
            return createResponse(collection.map(item => ({ ...item })), 200);
        }

        if (method === "GET") {
            const item = collection.find(record => record.id === id);
            return item
                ? createResponse({ ...item }, 200)
                : createResponse({ message: "Data demo tidak ditemukan." }, 404);
        }

        if (method === "POST") {
            const data = JSON.parse(options.body || "{}");
            const newItem = {
                ...data,
                id: collection.reduce((highestId, item) => Math.max(highestId, item.id), 0) + 1
            };
            collection.push(newItem);
            return createResponse({ message: "Data demo berhasil ditambahkan.", data: { ...newItem } }, 201);
        }

        const index = collection.findIndex(item => item.id === id);
        if (index === -1) {
            return createResponse({ message: "Data demo tidak ditemukan." }, 404);
        }

        if (method === "PUT") {
            const data = JSON.parse(options.body || "{}");
            collection[index] = { ...collection[index], ...data, id };
            return createResponse({ message: "Data demo berhasil diperbarui.", data: { ...collection[index] } }, 200);
        }

        if (method === "DELETE") {
            const [deletedItem] = collection.splice(index, 1);
            return createResponse({ message: "Data demo berhasil dihapus.", data: deletedItem }, 200);
        }

        return createResponse({ message: "Metode demo tidak didukung." }, 405);
    };

    const main = document.querySelector("main");
    if (main) {
        const notice = document.createElement("p");
        notice.className = "mb-6 rounded-lg border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-blue-800";
        notice.setAttribute("role", "status");
        notice.textContent = "Mode demo: perubahan data hanya sementara dan kembali seperti semula saat halaman dimuat ulang atau dibuka kembali.";
        main.prepend(notice);
    }
})();
