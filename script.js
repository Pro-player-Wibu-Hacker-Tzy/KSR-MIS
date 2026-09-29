// Mengambil elemen select
const kategori = document.getElementById("kategori");

// Mengambil elemen untuk menampilkan hasil
const hasilKategori = document.getElementById("hasilKategori");


// Menangani event ketika pilihan berubah
kategori.addEventListener("change", function () {

    // Jika belum memilih
    if (kategori.value === "") {

        hasilKategori.textContent =
            "Silakan pilih salah satu layanan.";

        return;
    }


    // Menampilkan pilihan user
    hasilKategori.textContent =
        "Kamu memilih layanan: " + kategori.value;

});