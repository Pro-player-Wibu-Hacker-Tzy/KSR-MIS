const API_URL = "http://localhost:3000/api/informasi";

// Elemen HTML
const totalInformasi = document.getElementById("totalInformasi");
const totalPelatihan = document.getElementById("totalPelatihan");
const totalKegiatan = document.getElementById("totalKegiatan");
const btnTambah = document.getElementById("btnTambah");
const loading = document.getElementById("loading");
const errorMessage = document.getElementById("errorMessage");
const formContainer = document.getElementById("formContainer");
const formTitle = document.getElementById("formTitle");
const btnBatal = document.getElementById("btnBatal");
const btnSimpan = document.getElementById("btnSimpan");
const informasiForm = document.getElementById("informasiForm");

const judulInput = document.getElementById("judul");
const isiInput = document.getElementById("isi");
const tanggalInput = document.getElementById("tanggal");
const kategoriInput = document.getElementById("kategori");

const informasiContainer = document.getElementById("informasiContainer");
const emptyState = document.getElementById("emptyState");

let editId = null;

// ==========================================
// LOAD DATA
// ==========================================
async function loadInformasi() {
    showLoading(true);
    hideError();
    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error("Gagal mengambil data informasi.");
        const data = await response.json();
        renderInformasi(data);
    } catch (error) {
        console.error("Error:", error);
        showError("Tidak dapat mengambil data informasi. Pastikan backend sedang berjalan.");
    } finally {
        showLoading(false);
    }
}

// ==========================================
// RENDER DATA
// ==========================================
function renderInformasi(data) {
    informasiContainer.innerHTML = "";

    // Statistik
    totalInformasi.textContent = data.length;
    const jumlahPelatihan = data.filter(item => item.kategori === "Pelatihan").length;
    const jumlahKegiatan = data.filter(item => item.kategori === "Kegiatan").length;
    totalPelatihan.textContent = jumlahPelatihan;
    totalKegiatan.textContent = jumlahKegiatan;

    if (data.length === 0) {
        emptyState.classList.remove("hidden");
        return;
    }
    emptyState.classList.add("hidden");

    data.forEach(item => {
        const card = document.createElement("article");
        card.className = "rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 transition hover:-translate-y-0.5 hover:shadow-md flex flex-col";

        card.innerHTML = `
            <div class="mb-3 flex items-start justify-between gap-3">
                <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-700">
                    ${escapeHTML(item.kategori)}
                </span>
                <span class="text-xs text-gray-500">${formatTanggal(item.tanggal)}</span>
            </div>

            <h3 class="text-lg font-bold text-gray-900 mb-2">
                ${escapeHTML(item.judul)}
            </h3>

            <p class="text-sm text-gray-600 line-clamp-3 mb-4 flex-grow">
                ${escapeHTML(item.isi)}
            </p>

            <div class="mt-4 flex gap-2 border-t border-gray-100 pt-4">
                <button type="button" onclick="editInformasi(${item.id})" class="flex-1 rounded-lg bg-yellow-500 px-3 py-2 text-xs font-semibold text-white transition hover:bg-yellow-600">Edit</button>
                <button type="button" onclick="deleteInformasi(${item.id})" class="flex-1 rounded-lg bg-red-600 px-3 py-2 text-xs font-semibold text-white transition hover:bg-red-700">Hapus</button>
            </div>
        `;
        informasiContainer.appendChild(card);
    });
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
    formTitle.textContent = "Tambah Informasi";
    informasiForm.reset();
    btnSimpan.textContent = "Simpan";
    formContainer.classList.remove("hidden");
    judulInput.focus();
    window.scrollTo({ top: formContainer.offsetTop - 20, behavior: "smooth" });
}

async function editInformasi(id) {
    hideError();
    try {
        const response = await fetch(`${API_URL}/${id}`);
        if (!response.ok) throw new Error("Gagal mengambil data informasi.");
        const item = await response.json();

        editId = item.id;
        formTitle.textContent = "Edit Informasi";
        judulInput.value = item.judul;
        isiInput.value = item.isi;
        tanggalInput.value = item.tanggal;
        kategoriInput.value = item.kategori;

        btnSimpan.textContent = "Update";
        formContainer.classList.remove("hidden");
        judulInput.focus();
        window.scrollTo({ top: formContainer.offsetTop - 20, behavior: "smooth" });
    } catch (error) {
        console.error("Error:", error);
        showError("Gagal mengambil data informasi untuk diedit.");
    }
}

// ==========================================
// SUBMIT FORM
// ==========================================
informasiForm.addEventListener("submit", async function (event) {
    event.preventDefault();
    hideError();

    const data = {
        judul: judulInput.value.trim(),
        isi: isiInput.value.trim(),
        tanggal: tanggalInput.value,
        kategori: kategoriInput.value.trim()
    };

    if (!data.judul || !data.isi || !data.tanggal || !data.kategori) {
        showError("Mohon lengkapi semua data informasi.");
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

        if (!response.ok) throw new Error("Gagal menyimpan data informasi.");
        closeForm();
        await loadInformasi();
    } catch (error) {
        console.error("Error:", error);
        showError("Gagal menyimpan data informasi.");
    } finally {
        btnSimpan.disabled = false;
        btnSimpan.textContent = textSimpan;
    }
});

// ==========================================
// DELETE
// ==========================================
async function deleteInformasi(id) {
    const yakin = confirm("Apakah kamu yakin ingin menghapus informasi ini?");
    if (!yakin) return;
    hideError();
    try {
        const response = await fetch(`${API_URL}/${id}`, { method: "DELETE" });
        if (!response.ok) throw new Error("Gagal menghapus data informasi.");
        await loadInformasi();
    } catch (error) {
        console.error("Error:", error);
        showError("Gagal menghapus data informasi.");
    }
}

// ==========================================
// CLOSE FORM
// ==========================================
function closeForm() {
    formContainer.classList.add("hidden");
    informasiForm.reset();
    editId = null;
    formTitle.textContent = "Tambah Informasi";
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
        informasiContainer.classList.add("hidden");
    } else {
        loading.classList.add("hidden");
        informasiContainer.classList.remove("hidden");
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

loadInformasi();