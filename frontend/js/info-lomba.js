const API_URL = 'http://localhost:3000/api/info-lomba';

// DOM Elements
const form = document.getElementById('data-form');
const tableBody = document.getElementById('table-body');
const loading = document.getElementById('loading');
const errorMessage = document.getElementById('error-message');
const errorText = document.getElementById('error-text');
const formTitle = document.getElementById('form-title');
const cancelBtn = document.getElementById('cancel-btn');

let editId = null;

// Initialize
document.addEventListener('DOMContentLoaded', fetchData);
form.addEventListener('submit', handleSubmit);

// Show/Hide Utilities
function showLoading() { loading.classList.remove('hidden'); }
function hideLoading() { loading.classList.add('hidden'); }
function showError(msg) {
    errorText.textContent = msg;
    errorMessage.classList.remove('hidden');
    setTimeout(() => errorMessage.classList.add('hidden'), 5000);
}

// Fetch Data (GET)
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

// Render Table
function renderTable(data) {
    tableBody.innerHTML = '';
    
    if (!data || data.length === 0) {
        tableBody.innerHTML = '<tr><td colspan="7" class="text-center py-4">Tidak ada data</td></tr>';
        return;
    }

    data.forEach(item => {
        const tr = document.createElement('tr');
        tr.className = 'border-b hover:bg-gray-100';
        tr.innerHTML = `
            <td class="py-2 px-4">${item.id}</td>
            <td class="py-2 px-4">${item.namaLomba}</td>
            <td class="py-2 px-4">${item.penyelenggara}</td>
            <td class="py-2 px-4">${item.tanggal}</td>
            <td class="py-2 px-4">${item.lokasi}</td>
            <td class="py-2 px-4">${item.status}</td>
            <td class="py-2 px-4 text-center">
                <button onclick="editData(${item.id}, '${item.namaLomba}', '${item.penyelenggara}', '${item.tanggal}', '${item.lokasi}', '${item.status}')" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm mr-1">Edit</button>
                <button onclick="deleteData(${item.id})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">Hapus</button>
            </td>
        `;
        tableBody.appendChild(tr);
    });
}

// Handle Form Submit (POST / PUT)
async function handleSubmit(e) {
    e.preventDefault();
    
    const payload = {
        namaLomba: document.getElementById('namaLomba').value,
        penyelenggara: document.getElementById('penyelenggara').value,
        tanggal: document.getElementById('tanggal').value,
        lokasi: document.getElementById('lokasi').value,
        status: document.getElementById('status').value
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
        fetchData(); // Refresh data
    } catch (error) {
        showError(error.message);
    }
}

// Edit Data
function editData(id, namaLomba, penyelenggara, tanggal, lokasi, status) {
    editId = id;
    document.getElementById('data-id').value = id;
    document.getElementById('namaLomba').value = namaLomba;
    document.getElementById('penyelenggara').value = penyelenggara;
    document.getElementById('tanggal').value = tanggal;
    document.getElementById('lokasi').value = lokasi;
    document.getElementById('status').value = status;

    formTitle.textContent = 'Edit Info Lomba';
    cancelBtn.classList.remove('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

// Delete Data
async function deleteData(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;

    try {
        const response = await fetch(`${API_URL}/${id}`, { method: 'DELETE' });
        if (!response.ok) throw new Error('Gagal menghapus data');
        fetchData(); // Refresh data
    } catch (error) {
        showError(error.message);
    }
}

// Reset Form
function resetForm() {
    editId = null;
    form.reset();
    document.getElementById('data-id').value = '';
    formTitle.textContent = 'Tambah Info Lomba';
    cancelBtn.classList.add('hidden');
}