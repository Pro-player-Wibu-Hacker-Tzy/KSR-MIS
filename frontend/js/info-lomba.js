const API_URL = "http://localhost:3000/api/info-lomba";

// Elemen HTML
const totalLomba = document.getElementById("totalLomba");
const totalAkanDatang = document.getElementById("totalAkanDatang");
const totalSelesai = document.getElementById("totalSelesai");
const btnTambah = document.getElementById("btnTambah");
const loading = document.getElementById("loading");
const errorMessage = document.getElementById("errorMessage");
const formContainer = document.getElementById("formContainer");
const formTitle = document.getElementById("formTitle");
const btnBatal = document.getElementById("btnBatal");
const btnSimpan = document.getElementById("btnSimpan");
const infoLombaForm = document.getElementById("infoLombaForm");

const namaLombaInput = document.getElementById("namaLomba");
const penyelenggaraInput = document.getElementById("penyelenggara");
const tanggalInput = document.getElementById("tanggal");
const lokasiInput = document.getElementById("lokasi");
const statusInput = document.getElementById("status");

const infoLombaTableBody = document.getElementById("infoLombaTableBody");
const emptyState = document.getElementById("emptyState");

let editId = null;

// ==========================================
// LOAD DATA
// ==========================================
async function loadInfoLomba() {
    showLoading(true);
    hideError();
    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Gagal mengambil data info lomba.");
        const data = await response.json();
        renderInfoLomba(data);
    } catch (error) {
        console.error("Error:", error);
        showError("Tidak dapat mengambil data info lomba. Pastikan backend sedang berjalan.");
    } finally {
        showLoading(false);
    }
}

// ==========================================
// RENDER DATA
// ==========================================
function renderInfoLomba(data) {
    infoLombaTableBody.innerHTML = "";

    // Statistik
    totalLomba.textContent = data.length;
    const jumlahAkanDatang = data.filter(item => item.status === "Akan Datang").length;
    const jumlahSelesai = data.filter(item => item.status === "Selesai").length;
    totalAkanDatang.textContent = jumlahAkanDatang;
    totalSelesai.textContent = jumlahSelesai;

    if (data.length === 0) {
        emptyState.classList.remove("hidden");
        return;
    }
    emptyState.classList.add("hidden");

    data.forEach((item, index) => {
        const row = document.createElement("tr");
        row.className = "transition hover:bg-gray-50";
        row.innerHTML = `
            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">${index + 1}</td>
            <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-gray-900">${escapeHTML(item.namaLomba)}</td>
            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">${escapeHTML(item.penyelenggara)}</td>
            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">${formatTanggal(item.tanggal)}</td>
            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">${escapeHTML(item.lokasi)}</td>
            <td class="whitespace-nowrap px-4 py-4 text-sm">${getStatusBadge(item.status)}</td>
            <td class="whitespace-nowrap px-4 py-4 text-sm">
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="editInfoLomba(${item.id})" class="rounded-lg bg-yellow-500 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-yellow-600">Edit</button>
                    <button type="button" onclick="deleteInfoLomba(${item.id})" class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-red-700">Hapus</button>
                </div>
            </td>
        `;
        infoLombaTableBody.appendChild(row);
    });
}

function getStatusBadge(status) {
    if (status === "Akan Datang") {
        return `<span class="inline-flex rounded-full bg-orange-100 px-2.5 py-1 text-xs font-semibold text-orange-700">Akan Datang</span>`;
    }
    if (status === "Berlangsung") {
        return `<span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">Berlangsung</span>`;
    }
    if (status === "Selesai") {
        return `<span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">Selesai</span>`;
    }
    return `<span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">${escapeHTML(status)}</span>`;
}

function formatTanggal(tanggal) {
    if (!tanggal) return "-";
    const date = new Date(tanggal);
    if (Number.isNaN(date.getTime())) return escapeHTML(tanggal);
    return date.toLocaleDateString("id-ID", { day: "2-digit", month: "long", year: "numeric" });
}

// ==========================================
// TAMBAH / EDIT FORM
// ==========================================
function openAddForm() {
    editId = null;
    formTitle.textContent = "Tambah Info Lomba";
    infoLombaForm.reset();
    btnSimpan.textContent = "Simpan";
    formContainer.classList.remove("hidden");
    namaLombaInput.focus();
    window.scrollTo({ top: formContainer.offsetTop - 20, behavior: "smooth" });
}

async function editInfoLomba(id) {
    hideError();
    try {
        const response = await fetch(`${API_URL}/${id}`);
        if (!response.ok) throw new Error("Gagal mengambil data info lomba.");
        const item = await response.json();

        editId = item.id;
        formTitle.textContent = "Edit Info Lomba";
        namaLombaInput.value = item.namaLomba;
        penyelenggaraInput.value = item.penyelenggara;
        tanggalInput.value = item.tanggal;
        lokasiInput.value = item.lokasi;
        statusInput.value = item.status;

        btnSimpan.textContent = "Update";
        formContainer.classList.remove("hidden");
        namaLombaInput.focus();
        window.scrollTo({ top: formContainer.offsetTop - 20, behavior: "smooth" });
    } catch (error) {
        console.error("Error:", error);
        showError("Gagal mengambil data info lomba untuk diedit.");
    }
}

// ==========================================
// SUBMIT FORM
// ==========================================
infoLombaForm.addEventListener("submit", async function (event) {
    event.preventDefault();
    hideError();

    const data = {
        namaLomba: namaLombaInput.value.trim(),
        penyelenggara: penyelenggaraInput.value.trim(),
        tanggal: tanggalInput.value,
        lokasi: lokasiInput.value.trim(),
        status: statusInput.value
    };

    if (!data.namaLomba || !data.penyelenggara || !data.tanggal || !data.lokasi || !data.status) {
        showError("Mohon lengkapi semua data info lomba.");
        return;
    }

    btnSimpan.disabled = true;
    const textSimpan = btnSimpan.textContent;
    btnSimpan.textContent = "Menyimpan...";

    try {
        let response;
        if (editId !== null) {
            response = await fetch(`${API_URL}/${editId}`, {
                method: "PUT",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });
        } else {
            response = await fetch(API_URL, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(data)
            });
        }

        if (!response.ok) throw new Error("Gagal menyimpan data info lomba.");
        closeForm();
        await loadInfoLomba();
    } catch (error) {
        console.error("Error:", error);
        showError("Gagal menyimpan data info lomba.");
    } finally {
        btnSimpan.disabled = false;
        btnSimpan.textContent = textSimpan;
    }
});

// ==========================================
// DELETE
// ==========================================
async function deleteInfoLomba(id) {
    const yakin = confirm("Apakah kamu yakin ingin menghapus info lomba ini?");
    if (!yakin) return;
    hideError();
    try {
        const response = await fetch(`${API_URL}/${id}`, { method: "DELETE" });
        if (!response.ok) throw new Error("Gagal menghapus data info lomba.");
        await loadInfoLomba();
    } catch (error) {
        console.error("Error:", error);
        showError("Gagal menghapus data info lomba.");
    }
}

// ==========================================
// CLOSE FORM
// ==========================================
function closeForm() {
    formContainer.classList.add("hidden");
    infoLombaForm.reset();
    editId = null;
    formTitle.textContent = "Tambah Info Lomba";
    btnSimpan.textContent = "Simpan";
}

btnTambah.addEventListener("click", openAddForm);
btnBatal.addEventListener("click", closeForm);

// ==========================================
// LOADING & ERROR
// ==========================================
function showLoading(isLoading) {
    if (isLoading) {
        loading.classList.remove("hidden");
        infoLombaTableBody.classList.add("hidden");
    } else {
        loading.classList.add("hidden");
        infoLombaTableBody.classList.remove("hidden");
    }
}

function showError(message) {
    errorMessage.textContent = message;
    errorMessage.classList.remove("hidden");
}

function hideError() {
    errorMessage.textContent = "";
    errorMessage.classList.add("hidden");
}

function escapeHTML(value) {
    return String(value)
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

loadInfoLomba();