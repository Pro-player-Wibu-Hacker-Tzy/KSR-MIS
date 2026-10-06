const API_URL = "http://localhost:3000/api/inventaris";

// Elemen HTML
const totalBarang = document.getElementById("totalBarang");
const totalTersedia = document.getElementById("totalTersedia");
const totalDipinjam = document.getElementById("totalDipinjam");

const btnTambah = document.getElementById("btnTambah");

const loading = document.getElementById("loading");
const errorMessage = document.getElementById("errorMessage");

const formContainer = document.getElementById("formContainer");
const formTitle = document.getElementById("formTitle");

const btnTutupForm = document.getElementById("btnTutupForm");
const btnBatal = document.getElementById("btnBatal");
const btnSimpan = document.getElementById("btnSimpan");

const inventarisForm = document.getElementById("inventarisForm");

const namaInput = document.getElementById("nama");
const jumlahInput = document.getElementById("jumlah");
const kondisiInput = document.getElementById("kondisi");
const statusInput = document.getElementById("status");

const inventarisTableBody = document.getElementById("inventarisTableBody");
const emptyState = document.getElementById("emptyState");

// ID data yang sedang diedit
let editId = null;


// ==========================================
// LOAD DATA
// ==========================================

async function loadInventaris() {
    showLoading(true);
    hideError();

    try {
        const response = await fetch(API_URL);

        if (!response.ok) {
            throw new Error("Gagal mengambil data inventaris.");
        }

        const data = await response.json();

        renderInventaris(data);

    } catch (error) {
        console.error("Error:", error);
        showError("Tidak dapat mengambil data inventaris. Pastikan backend sedang berjalan.");
    } finally {
        showLoading(false);
    }
}


// ==========================================
// RENDER DATA
// ==========================================

function renderInventaris(data) {

    inventarisTableBody.innerHTML = "";

    // Statistik
    totalBarang.textContent = data.length;

    const jumlahTersedia = data.filter(
        item => item.status === "Tersedia"
    ).length;

    const jumlahDipinjam = data.filter(
        item => item.status === "Dipinjam"
    ).length;

    totalTersedia.textContent = jumlahTersedia;
    totalDipinjam.textContent = jumlahDipinjam;


    // Empty state
    if (data.length === 0) {
        emptyState.classList.remove("hidden");
        return;
    }

    emptyState.classList.add("hidden");


    // Render tabel
    data.forEach((item, index) => {

        const row = document.createElement("tr");

        row.className = "transition hover:bg-gray-50";

        row.innerHTML = `
            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">
                ${index + 1}
            </td>

            <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-gray-900">
                ${escapeHTML(item.nama)}
            </td>

            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">
                ${item.jumlah}
            </td>

            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">
                ${escapeHTML(item.kondisi)}
            </td>

            <td class="whitespace-nowrap px-4 py-4 text-sm">
                ${getStatusBadge(item.status)}
            </td>

            <td class="whitespace-nowrap px-4 py-4 text-sm">
                <div class="flex flex-wrap gap-2">

                    <button
                        type="button"
                        onclick="editInventaris(${item.id})"
                        class="rounded-lg bg-yellow-500 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-yellow-600"
                    >
                        Edit
                    </button>

                    <button
                        type="button"
                        onclick="deleteInventaris(${item.id})"
                        class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-red-700"
                    >
                        Hapus
                    </button>

                </div>
            </td>
        `;

        inventarisTableBody.appendChild(row);
    });
}


// ==========================================
// STATUS BADGE
// ==========================================

function getStatusBadge(status) {

    if (status === "Tersedia") {
        return `
            <span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                Tersedia
            </span>
        `;
    }

    if (status === "Dipinjam") {
        return `
            <span class="inline-flex rounded-full bg-orange-100 px-2.5 py-1 text-xs font-semibold text-orange-700">
                Dipinjam
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
// TAMBAH / EDIT FORM
// ==========================================

function openAddForm() {

    editId = null;

    formTitle.textContent = "Tambah Inventaris";

    inventarisForm.reset();

    btnSimpan.textContent = "Simpan";

    formContainer.classList.remove("hidden");

    namaInput.focus();

    window.scrollTo({
        top: formContainer.offsetTop - 20,
        behavior: "smooth"
    });
}


async function editInventaris(id) {

    hideError();

    try {

        const response = await fetch(`${API_URL}/${id}`);

        if (!response.ok) {
            throw new Error("Gagal mengambil data inventaris.");
        }

        const item = await response.json();

        editId = item.id;

        formTitle.textContent = "Edit Inventaris";

        namaInput.value = item.nama;
        jumlahInput.value = item.jumlah;
        kondisiInput.value = item.kondisi;
        statusInput.value = item.status;

        btnSimpan.textContent = "Update";

        formContainer.classList.remove("hidden");

        namaInput.focus();

        window.scrollTo({
            top: formContainer.offsetTop - 20,
            behavior: "smooth"
        });

    } catch (error) {

        console.error("Error:", error);

        showError("Gagal mengambil data inventaris untuk diedit.");
    }
}


// ==========================================
// SUBMIT FORM
// ==========================================

inventarisForm.addEventListener("submit", async function (event) {

    event.preventDefault();

    hideError();

    const data = {
        nama: namaInput.value.trim(),
        jumlah: Number(jumlahInput.value),
        kondisi: kondisiInput.value,
        status: statusInput.value
    };


    // Validasi sederhana
    if (
        !data.nama ||
        data.jumlah < 0 ||
        !data.kondisi ||
        !data.status
    ) {
        showError("Mohon lengkapi semua data inventaris.");
        return;
    }


    // Disable tombol ketika request berjalan
    btnSimpan.disabled = true;

    const textSimpan = btnSimpan.textContent;
    btnSimpan.textContent = "Menyimpan...";


    try {

        let response;


        // EDIT
        if (editId !== null) {

            response = await fetch(`${API_URL}/${editId}`, {
                method: "PUT",

                headers: {
                    "Content-Type": "application/json"
                },

                body: JSON.stringify(data)
            });

        }


        // TAMBAH
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
            throw new Error("Gagal menyimpan data inventaris.");
        }


        // Tutup form
        closeForm();


        // Refresh data dari backend
        await loadInventaris();

    } catch (error) {

        console.error("Error:", error);

        showError("Gagal menyimpan data inventaris.");

    } finally {

        btnSimpan.disabled = false;
        btnSimpan.textContent = textSimpan;
    }
});


// ==========================================
// DELETE
// ==========================================

async function deleteInventaris(id) {

    const yakin = confirm(
        "Apakah kamu yakin ingin menghapus inventaris ini?"
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
            throw new Error("Gagal menghapus data inventaris.");
        }


        // Refresh data setelah berhasil hapus
        await loadInventaris();

    } catch (error) {

        console.error("Error:", error);

        showError("Gagal menghapus data inventaris.");
    }
}


// ==========================================
// CLOSE FORM
// ==========================================

function closeForm() {

    formContainer.classList.add("hidden");

    inventarisForm.reset();

    editId = null;

    formTitle.textContent = "Tambah Inventaris";

    btnSimpan.textContent = "Simpan";
}


btnTambah.addEventListener("click", openAddForm);

btnBatal.addEventListener("click", closeForm);


// ==========================================
// LOADING
// ==========================================

function showLoading(isLoading) {

    if (isLoading) {

        loading.classList.remove("hidden");

        inventarisTableBody.classList.add("hidden");

    } else {

        loading.classList.add("hidden");

        inventarisTableBody.classList.remove("hidden");
    }
}


// ==========================================
// ERROR MESSAGE
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
// KEAMANAN OUTPUT HTML
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
// LOAD DATA SAAT HALAMAN DIBUKA
// ==========================================

loadInventaris();