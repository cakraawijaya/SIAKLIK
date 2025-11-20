document.addEventListener("DOMContentLoaded", function() {
    window.openLink = function(url, openInNewTab = true) {

        // Jika URL diawali "#" atau kosong → tidak melakukan apa-apa
        if (url.startsWith("#") || url.trim() === "") {
            return true;
        }

        // Jika email
        if (url.startsWith("mailto:")) {
            window.location.href = url;
            return true;
        }

        // Jika bukan email
        if (openInNewTab) {
            window.open(url, "_blank", "noopener,noreferrer");
        } else {
            window.location.href = url;
        }

        return true;
    };
});