// Jalankan script setelah seluruh DOM selesai dimuat
document.addEventListener("DOMContentLoaded", function() {

    // Buat fungsi global untuk membuka link, bisa di tab baru atau di tab yang sama
    window.openLink = function(url, openInNewTab = true) {

        // Jika URL diawali "#" atau kosong, maka tidak melakukan apa-apa
        if (url.startsWith("#") || url.trim() === "") {
            return true; // Mengakhiri eksekusi fungsi
        }

        // Jika email
        if (url.startsWith("mailto:")) {
            window.location.href = url; // Mengarahkan browser ke email client
            return true; // Mengakhiri eksekusi fungsi
        }

        // Jika bukan email
        if (openInNewTab) {
            window.open(
                url,                    // Alamat yang ingin dibuka
                "_blank",               // Buka di tab baru
                "noopener, noreferrer"  // Agar tab baru aman dan tidak bisa mengakses halaman asal
            );

        } else { // Selain itu, maka :
            window.location.href = url; // Buka URL di tab yang sama
        }

        return true; // Mengakhiri eksekusi fungsi
    };
});