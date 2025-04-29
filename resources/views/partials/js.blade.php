<!-- Core JS -->
 <!-- Jquery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>

<script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script>

<!-- Place this tag in your head or just before your close body tag. -->


<!-- Datatables -->
<script src="https://cdn.datatables.net/2.2.2/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>


<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- JS de Select2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.body.style.visibility = "visible";
        document.body.style.opacity = "1";
    });

    //load loading overlay

    function toggleLoader(visible = true, customMessage = null) {
        const overlay = document.getElementById("loadingOverlay");
        if (!overlay) return;

        overlay.style.display = visible ? "block" : "none";
        if (customMessage) {
            overlay.querySelector("h5").innerText = customMessage;
        }
    }

    // Activación automática al enviar formularios con clase .show-loader
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll("form.show-loader").forEach(form => {
            form.addEventListener("submit", () => toggleLoader(true));
        });

        $('[data-bs-toggle="tooltip"]').tooltip();
    });

    
</script>