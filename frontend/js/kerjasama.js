const API_URL = "http://localhost:3000/api/kerjasama";

// ==========================================
// ELEMENT HTML
// ==========================================

const totalMitra = document.getElementById("totalMitra");
const totalAktif = document.getElementById("totalAktif");
const totalPengajuan = document.getElementById("totalPengajuan");

const btnTambah = document.getElementById("btnTambah");

const loading = document.getElementById("loading");
const errorMessage = document.getElementById("errorMessage");

const formContainer = document.getElementById("formContainer");
const formTitle = document.getElementById("formTitle");

const btnBatal = document.getElementById("btnBatal");
const btnSimpan = document.getElementById("btnSimpan");

const kerjasamaForm = document.getElementById("kerjasamaForm");

const namaInstansiInput = document.getElementById("namaInstansi");
const jenisKerjasamaInput = document.getElementById("jenisKerjasama");
const tanggalInput = document.getElementById("tanggal");
const statusInput = document.getElementById("status");

const kerjasamaContainer = document.getElementById("kerjasamaContainer");
const emptyState = document.getElementById("emptyState");


// ID data yang sedang diedit
let editId = null;


// ==========================================
// LOAD DATA
// ==========================================

async function loadKerjasama() {

    showLoading(true);
    hideError();

    try {

        const response = await fetch(API_URL);

        if (!response.ok) {
            throw new Error("Gagal mengambil data kerja sama.");
        }

        const data = await response.json();

        renderKerjasama(data);

    } catch (error) {

        console.error("Error:", error);

        showError(
            "Tidak dapat mengambil data kerja sama. Pastikan backend sedang berjalan."
        );

    } finally {

        showLoading(false);
    }
}


// ==========================================
// RENDER DATA
// ==========================================

function renderKerjasama(data) {

    kerjasamaContainer.innerHTML = "";


    // ======================================
    // STATISTIK
    // ======================================

    totalMitra.textContent = data.length;

    const jumlahAktif = data.filter(
        item => item.status === "Aktif"
    ).length;

    const jumlahPengajuan = data.filter(
        item => item.status === "Pengajuan"
    ).length;

    totalAktif.textContent = jumlahAktif;
    totalPengajuan.textContent = jumlahPengajuan;


    // ======================================
    // EMPTY STATE
    // ======================================

    if (data.length === 0) {

        emptyState.classList.remove("hidden");

        return;
    }

    emptyState.classList.add("hidden");


    // ======================================
    // RENDER CARD
    // ======================================

    data.forEach(item => {

        const card = document.createElement("article");

        card.className =
            "rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-md";


        card.innerHTML = `

            <!-- Card Header -->
            <div class="mb-4 flex items-start justify-between gap-3">

                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100 font-bold text-red-700">
                    ${getInitials(item.namaInstansi)}
                </div>

                ${getStatusBadge(item.status)}

            </div>


            <!-- Nama Instansi -->
            <h3 class="text-lg font-bold text-gray-900">
                ${escapeHTML(item.namaInstansi)}
            </h3>


            <!-- Jenis Kerja Sama -->
            <p class="mt-2 text-sm text-gray-600">
                ${escapeHTML(item.jenisKerjasama)}
            </p>


            <!-- Information -->
            <div class="mt-4 space-y-2 border-t border-gray-100 pt-4 text-sm text-gray-500">

                <div class="flex items-center gap-2">
                    <span>📅</span>
                    <span>${formatTanggal(item.tanggal)}</span>
                </div>

                <div class="flex items-center gap-2">
                    <span>🤝</span>
                    <span>Kerja Sama</span>
                </div>

            </div>


            <!-- Actions -->
            <div class="mt-5 flex gap-2">

                <button
                    type="button"
                    onclick="editKerjasama(${item.id})"
                    class="flex-1 rounded-lg bg-yellow-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-yellow-600"
                >
                    Edit
                </button>

                <button
                    type="button"
                    onclick="deleteKerjasama(${item.id})"
                    class="flex-1 rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700"
                >
                    Hapus
                </button>

            </div>
        `;


        kerjasamaContainer.appendChild(card);
    });
}


// ==========================================
// STATUS BADGE
// ==========================================

function getStatusBadge(status) {

    if (status === "Aktif") {

        return `
            <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                Aktif
            </span>
        `;
    }


    if (status === "Pengajuan") {

        return `
            <span class="inline-flex rounded-full bg-orange-100 px-2.5 py-1 text-xs font-semibold text-orange-700">
                Pengajuan
            </span>
        `;
    }


    if (status === "Selesai") {

        return `
            <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                Selesai
            </span>
        `;
    }


    return `
        <span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">
            ${escapeHTML(status)}
        </span>
    `;
}


// ==========================================
// INITIALS
// ==========================================

function getInitials(name) {

    const words = String(name)
        .trim()
        .split(/\s+/)
        .filter(Boolean);

    if (words.length === 0) {
        return "?";
    }

    if (words.length === 1) {
        return words[0].substring(0, 3).toUpperCase();
    }

    return (
        words[0].charAt(0) +
        words[1].charAt(0)
    ).toUpperCase();
}


// ==========================================
// FORMAT TANGGAL
// ==========================================

function formatTanggal(tanggal) {

    if (!tanggal) {
        return "-";
    }

    const date = new Date(tanggal);

    if (Number.isNaN(date.getTime())) {
        return escapeHTML(tanggal);
    }

    return date.toLocaleDateString("id-ID", {
        day: "2-digit",
        month: "long",
        year: "numeric"
    });
}


// ==========================================
// TAMBAH FORM
// ==========================================

function openAddForm() {

    editId = null;

    formTitle.textContent = "Ajukan Kerja Sama";

    kerjasamaForm.reset();

    btnSimpan.textContent = "Simpan";

    formContainer.classList.remove("hidden");

    namaInstansiInput.focus();

    window.scrollTo({
        top: formContainer.offsetTop - 20,
        behavior: "smooth"
    });
}


// ==========================================
// EDIT DATA
// ==========================================

async function editKerjasama(id) {

    hideError();

    try {

        const response = await fetch(`${API_URL}/${id}`);

        if (!response.ok) {
            throw new Error("Gagal mengambil data kerja sama.");
        }

        const item = await response.json();

        editId = item.id;

        formTitle.textContent = "Edit Kerja Sama";

        namaInstansiInput.value = item.namaInstansi;
        jenisKerjasamaInput.value = item.jenisKerjasama;
        tanggalInput.value = item.tanggal;
        statusInput.value = item.status;

        btnSimpan.textContent = "Update";

        formContainer.classList.remove("hidden");

        namaInstansiInput.focus();

        window.scrollTo({
            top: formContainer.offsetTop - 20,
            behavior: "smooth"
        });

    } catch (error) {

        console.error("Error:", error);

        showError(
            "Gagal mengambil data kerja sama untuk diedit."
        );
    }
}


// ==========================================
// SUBMIT FORM
// ==========================================

kerjasamaForm.addEventListener("submit", async function (event) {

    event.preventDefault();

    hideError();


    // Data harus sesuai dengan struktur backend
    const data = {

        namaInstansi: namaInstansiInput.value.trim(),

        jenisKerjasama: jenisKerjasamaInput.value.trim(),

        tanggal: tanggalInput.value,

        status: statusInput.value

    };


    // ======================================
    // VALIDASI
    // ======================================

    if (
        !data.namaInstansi ||
        !data.jenisKerjasama ||
        !data.tanggal ||
        !data.status
    ) {

        showError(
            "Mohon lengkapi semua data kerja sama."
        );

        return;
    }


    // Disable tombol
    btnSimpan.disabled = true;

    const textSimpan = btnSimpan.textContent;

    btnSimpan.textContent = "Menyimpan...";


    try {

        let response;


        // ==================================
        // UPDATE
        // ==================================

        if (editId !== null) {

            response = await fetch(`${API_URL}/${editId}`, {

                method: "PUT",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify(data)

            });

        }


        // ==================================
        // CREATE
        // ==================================

        else {

            response = await fetch(API_URL, {

                method: "POST",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify(data)

            });

        }


        if (!response.ok) {
            throw new Error(
                "Gagal menyimpan data kerja sama."
            );
        }


        // Tutup form
        closeForm();


        // Ambil data terbaru dari backend
        await loadKerjasama();


    } catch (error) {

        console.error("Error:", error);

        showError(
            "Gagal menyimpan data kerja sama."
        );

    } finally {

        btnSimpan.disabled = false;

        btnSimpan.textContent = textSimpan;
    }

});


// ==========================================
// DELETE
// ==========================================

async function deleteKerjasama(id) {

    const yakin = confirm(
        "Apakah kamu yakin ingin menghapus kerja sama ini?"
    );

    if (!yakin) {
        return;
    }

    hideError();


    try {

        const response = await fetch(`${API_URL}/${id}`, {

            method: "DELETE"

        });


        if (!response.ok) {
            throw new Error(
                "Gagal menghapus data kerja sama."
            );
        }


        // Refresh data setelah delete
        await loadKerjasama();


    } catch (error) {

        console.error("Error:", error);

        showError(
            "Gagal menghapus data kerja sama."
        );
    }
}


// ==========================================
// CLOSE FORM
// ==========================================

function closeForm() {

    formContainer.classList.add("hidden");

    kerjasamaForm.reset();

    editId = null;

    formTitle.textContent = "Ajukan Kerja Sama";

    btnSimpan.textContent = "Simpan";
}


// ==========================================
// EVENT BUTTON
// ==========================================

btnTambah.addEventListener(
    "click",
    openAddForm
);

btnBatal.addEventListener(
    "click",
    closeForm
);


// ==========================================
// LOADING
// ==========================================

function showLoading(isLoading) {

    if (isLoading) {

        loading.classList.remove("hidden");

        kerjasamaContainer.classList.add("hidden");

    } else {

        loading.classList.add("hidden");

        kerjasamaContainer.classList.remove("hidden");
    }
}


// ==========================================
// ERROR
// ==========================================

function showError(message) {

    errorMessage.textContent = message;

    errorMessage.classList.remove("hidden");
}


function hideError() {

    errorMessage.textContent = "";

    errorMessage.classList.add("hidden");
}


// ==========================================
// ESCAPE HTML
// ==========================================

function escapeHTML(value) {

    return String(value)

        .replace(/&/g, "&amp;")

        .replace(/</g, "&lt;")

        .replace(/>/g, "&gt;")

        .replace(/"/g, "&quot;")

        .replace(/'/g, "&#039;");
}


// ==========================================
// LOAD SAAT HALAMAN DIBUKA
// ==========================================

loadKerjasama();