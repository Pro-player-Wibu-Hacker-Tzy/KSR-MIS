const API_URL = 'http://localhost:3000/api/informasi';

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
        tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-4">Tidak ada data</td></tr>';
        return;
    }

    data.forEach(item => {
        const tr = document.createElement('tr');
        tr.className = 'border-b hover:bg-gray-100';
        // Escape string untuk menghindari error saat ada karakter kutip
        const safeIsi = item.isi.replace(/'/g, "\\'").replace(/"/g, '&quot;');
        const safeJudul = item.judul.replace(/'/g, "\\'").replace(/"/g, '&quot;');
        
        tr.innerHTML = `
            <td class="py-2 px-4">${item.id}</td>
            <td class="py-2 px-4">${item.judul}</td>
            <td class="py-2 px-4 truncate max-w-xs" title="${item.isi}">${item.isi}</td>
            <td class="py-2 px-4">${item.tanggal}</td>
            <td class="py-2 px-4">${item.kategori}</td>
            <td class="py-2 px-4 text-center">
                <button onclick="editData(${item.id}, '${safeJudul}', '${safeIsi}', '${item.tanggal}', '${item.kategori}')" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm mr-1">Edit</button>
                <button onclick="deleteData(${item.id})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">Hapus</button>
            </td>
        `;
        tableBody.appendChild(tr);
    });
}

async function handleSubmit(e) {
    e.preventDefault();
    const payload = {
        judul: document.getElementById('judul').value,
        isi: document.getElementById('isi').value,
        tanggal: document.getElementById('tanggal').value,
        kategori: document.getElementById('kategori').value
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

function editData(id, judul, isi, tanggal, kategori) {
    editId = id;
    document.getElementById('data-id').value = id;
    document.getElementById('judul').value = judul;
    document.getElementById('isi').value = isi;
    document.getElementById('tanggal').value = tanggal;
    document.getElementById('kategori').value = kategori;

    formTitle.textContent = 'Edit Informasi';
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
    formTitle.textContent = 'Tambah Informasi';
    cancelBtn.classList.add('hidden');
}