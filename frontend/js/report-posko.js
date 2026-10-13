const API_URL = 'http://localhost:3000/api/report-posko';

const form = document.getElementById('data-form');
const tableBody = document.getElementById('table-body');
const loading = document.getElementById('loading');
const errorMessage = document.getElementById('error-message');
const errorText = document.getElementById('error-text');
const formTitle = document.getElementById('form-title');
const cancelBtn = document.getElementById('cancel-btn');

let editId = null;

document.addEventListener('DOMContentLoaded', fetchData);
form.addEventListener('submit', handleSubmit);

function showLoading() { loading.classList.remove('hidden'); }
function hideLoading() { loading.classList.add('hidden'); }
function showError(msg) {
    errorText.textContent = msg;
    errorMessage.classList.remove('hidden');
    setTimeout(() => errorMessage.classList.add('hidden'), 5000);
}

async function fetchData() {
    showLoading();
    try {
        const response = await fetch(API_URL);
        if (!response.ok) throw new Error('Gagal mengambil data dari server');
        const data = await response.json();
        renderTable(data);
    } catch (error) {
        showError(error.message);
    } finally {
        hideLoading();
    }
}

function renderTable(data) {
    tableBody.innerHTML = '';
    if (!data || data.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="8" class="text-center py-4">Tidak ada data</td></tr>';
        return;
    }

    data.forEach(item => {
        const tr = document.createElement('tr');
        tr.className = 'border-b hover:bg-gray-100';
        // Escape string untuk menghindari error saat ada karakter kutip
        const safeKeterangan = item.keterangan.replace(/'/g, "\\'").replace(/"/g, '&quot;');
        const safeNamaPosko = item.namaPosko.replace(/'/g, "\\'").replace(/"/g, '&quot;');
        const safeLokasi = item.lokasi.replace(/'/g, "\\'").replace(/"/g, '&quot;');
        const safeKondisi = item.kondisi.replace(/'/g, "\\'").replace(/"/g, '&quot;');

        tr.innerHTML = `
            <td class="py-2 px-4">${item.id}</td>
            <td class="py-2 px-4">${item.namaPosko}</td>
            <td class="py-2 px-4">${item.lokasi}</td>
            <td class="py-2 px-4">${item.tanggal}</td>
            <td class="py-2 px-4 text-center">${item.jumlahPetugas}</td>
            <td class="py-2 px-4">${item.kondisi}</td>
            <td class="py-2 px-4 truncate max-w-xs" title="${item.keterangan}">${item.keterangan}</td>
            <td class="py-2 px-4 text-center">
                <button onclick="editData(${item.id}, '${safeNamaPosko}', '${safeLokasi}', '${item.tanggal}', ${item.jumlahPetugas}, '${safeKondisi}', '${safeKeterangan}')" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm mr-1">Edit</button>
                <button onclick="deleteData(${item.id})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">Hapus</button>
            </td>
        `;
        tableBody.appendChild(tr);
    });
}

async function handleSubmit(e) {
    e.preventDefault();
    const payload = {
        namaPosko: document.getElementById('namaPosko').value,
        lokasi: document.getElementById('lokasi').value,
        tanggal: document.getElementById('tanggal').value,
        jumlahPetugas: parseInt(document.getElementById('jumlahPetugas').value),
        kondisi: document.getElementById('kondisi').value,
        keterangan: document.getElementById('keterangan').value
    };

    const method = editId ? 'PUT' : 'POST';
    const url = editId ? `${API_URL}/${editId}` : API_URL;

    try {
        const response = await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });
        if (!response.ok) throw new Error('Gagal menyimpan data');
        resetForm();
        fetchData();
    } catch (error) {
        showError(error.message);
    }
}

function editData(id, namaPosko, lokasi, tanggal, jumlahPetugas, kondisi, keterangan) {
    editId = id;
    document.getElementById('data-id').value = id;
    document.getElementById('namaPosko').value = namaPosko;
    document.getElementById('lokasi').value = lokasi;
    document.getElementById('tanggal').value = tanggal;
    document.getElementById('jumlahPetugas').value = jumlahPetugas;
    document.getElementById('kondisi').value = kondisi;
    document.getElementById('keterangan').value = keterangan;

    formTitle.textContent = 'Edit Report Posko';
    cancelBtn.classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

async function deleteData(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;
    try {
        const response = await fetch(`${API_URL}/${id}`, { method: 'DELETE' });
        if (!response.ok) throw new Error('Gagal menghapus data');
        fetchData();
    } catch (error) {
        showError(error.message);
    }
}

function resetForm() {
    editId = null;
    form.reset();
    document.getElementById('data-id').value = '';
    formTitle.textContent = 'Tambah Report Posko';
    cancelBtn.classList.add('hidden');
}