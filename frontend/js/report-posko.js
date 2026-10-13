const API_URL = "http://localhost:3000/api/report-posko";

// Elemen HTML
const totalPosko = document.getElementById("totalPosko");
const totalAman = document.getElementById("totalAman");
const totalPerhatian = document.getElementById("totalPerhatian");
const btnTambah = document.getElementById("btnTambah");
const loading = document.getElementById("loading");
const errorMessage = document.getElementById("errorMessage");
const formContainer = document.getElementById("formContainer");
const formTitle = document.getElementById("formTitle");
const btnBatal = document.getElementById("btnBatal");
const btnSimpan = document.getElementById("btnSimpan");
const reportPoskoForm = document.getElementById("reportPoskoForm");

const namaPoskoInput = document.getElementById("namaPosko");
const lokasiInput = document.getElementById("lokasi");
const tanggalInput = document.getElementById("tanggal");
const jumlahPetugasInput = document.getElementById("jumlahPetugas");
const kondisiInput = document.getElementById("kondisi");
const keteranganInput = document.getElementById("keterangan");

const reportPoskoTableBody = document.getElementById("reportPoskoTableBody");
const emptyState = document.getElementById("emptyState");

let editId = null;

// ==========================================
// LOAD DATA
// ==========================================
async function loadReportPosko() {
    showLoading(true);
    hideError();
    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Gagal mengambil data report posko.");
        const data = await response.json();
        renderReportPosko(data);
    } catch (error) {
        console.error("Error:", error);
        showError("Tidak dapat mengambil data report posko. Pastikan backend sedang berjalan.");
    } finally {
        showLoading(false);
    }
}

// ==========================================
// RENDER DATA
// ==========================================
function renderReportPosko(data) {
    reportPoskoTableBody.innerHTML = "";

    // Statistik
    totalPosko.textContent = data.length;
    const jumlahAman = data.filter(item => item.kondisi === "Aman").length;
    const jumlahPerhatian = data.filter(item => item.kondisi === "Perlu Perhatian" || item.kondisi === "Darurat").length;
    totalAman.textContent = jumlahAman;
    totalPerhatian.textContent = jumlahPerhatian;

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
            <td class="whitespace-nowrap px-4 py-4 text-sm font-medium text-gray-900">${escapeHTML(item.namaPosko)}</td>
            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">${escapeHTML(item.lokasi)}</td>
            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600">${formatTanggal(item.tanggal)}</td>
            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600 text-center">${item.jumlahPetugas}</td>
            <td class="whitespace-nowrap px-4 py-4 text-sm">${getKondisiBadge(item.kondisi)}</td>
            <td class="whitespace-nowrap px-4 py-4 text-sm text-gray-600 max-w-xs truncate" title="${escapeHTML(item.keterangan)}">${escapeHTML(item.keterangan)}</td>
            <td class="whitespace-nowrap px-4 py-4 text-sm">
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="editReportPosko(${item.id})" class="rounded-lg bg-yellow-500 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-yellow-600">Edit</button>
                    <button type="button" onclick="deleteReportPosko(${item.id})" class="rounded-lg bg-red-600 px-3 py-1.5 text-xs font-semibold text-white transition hover:bg-red-700">Hapus</button>
                </div>
            </td>
        `;
        reportPoskoTableBody.appendChild(row);
    });
}

function getKondisiBadge(kondisi) {
    if (kondisi === "Aman") {
        return `<span class="inline-flex rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">Aman</span>`;
    }
    if (kondisi === "Perlu Perhatian") {
        return `<span class="inline-flex rounded-full bg-orange-100 px-2.5 py-1 text-xs font-semibold text-orange-700">Perlu Perhatian</span>`;
    }
    if (kondisi === "Darurat") {
        return `<span class="inline-flex rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">Darurat</span>`;
    }
    return `<span class="inline-flex rounded-full bg-gray-100 px-2.5 py-1 text-xs font-semibold text-gray-700">${escapeHTML(kondisi)}</span>`;
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
    formTitle.textContent = "Tambah Report Posko";
    reportPoskoForm.reset();
    btnSimpan.textContent = "Simpan";
    formContainer.classList.remove("hidden");
    namaPoskoInput.focus();
    window.scrollTo({ top: formContainer.offsetTop - 20, behavior: "smooth" });
}

async function editReportPosko(id) {
    hideError();
    try {
        const response = await fetch(`${API_URL}/${id}`);
        if (!response.ok) throw new Error("Gagal mengambil data report posko.");
        const item = await response.json();

        editId = item.id;
        formTitle.textContent = "Edit Report Posko";
        namaPoskoInput.value = item.namaPosko;
        lokasiInput.value = item.lokasi;
        tanggalInput.value = item.tanggal;
        jumlahPetugasInput.value = item.jumlahPetugas;
        kondisiInput.value = item.kondisi;
        keteranganInput.value = item.keterangan;

        btnSimpan.textContent = "Update";
        formContainer.classList.remove("hidden");
        namaPoskoInput.focus();
        window.scrollTo({ top: formContainer.offsetTop - 20, behavior: "smooth" });
    } catch (error) {
        console.error("Error:", error);
        showError("Gagal mengambil data report posko untuk diedit.");
    }
}

// ==========================================
// SUBMIT FORM
// ==========================================
reportPoskoForm.addEventListener("submit", async function (event) {
    event.preventDefault();
    hideError();

    const data = {
        namaPosko: namaPoskoInput.value.trim(),
        lokasi: lokasiInput.value.trim(),
        tanggal: tanggalInput.value,
        jumlahPetugas: Number(jumlahPetugasInput.value),
        kondisi: kondisiInput.value,
        keterangan: keteranganInput.value.trim()
    };

    if (!data.namaPosko || !data.lokasi || !data.tanggal || data.jumlahPetugas < 0 || !data.kondisi || !data.keterangan) {
        showError("Mohon lengkapi semua data report posko.");
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

        if (!response.ok) throw new Error("Gagal menyimpan data report posko.");
        closeForm();
        await loadReportPosko();
    } catch (error) {
        console.error("Error:", error);
        showError("Gagal menyimpan data report posko.");
    } finally {
        btnSimpan.disabled = false;
        btnSimpan.textContent = textSimpan;
    }
});

// ==========================================
// DELETE
// ==========================================
async function deleteReportPosko(id) {
    const yakin = confirm("Apakah kamu yakin ingin menghapus report posko ini?");
    if (!yakin) return;
    hideError();
    try {
        const response = await fetch(`${API_URL}/${id}`, { method: "DELETE" });
        if (!response.ok) throw new Error("Gagal menghapus data report posko.");
        await loadReportPosko();
    } catch (error) {
        console.error("Error:", error);
        showError("Gagal menghapus data report posko.");
    }
}

// ==========================================
// CLOSE FORM
// ==========================================
function closeForm() {
    formContainer.classList.add("hidden");
    reportPoskoForm.reset();
    editId = null;
    formTitle.textContent = "Tambah Report Posko";
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
        reportPoskoTableBody.classList.add("hidden");
    } else {
        loading.classList.add("hidden");
        reportPoskoTableBody.classList.remove("hidden");
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

loadReportPosko();