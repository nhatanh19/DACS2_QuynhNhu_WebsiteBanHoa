            </div> <!-- End of main-content -->
        </div> <!-- End of content -->
    </div> <!-- End of wrapper -->

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Custom Scripts -->
    <script>
        $(document).ready(function() {
            // Toggle Sidebar
            $('#sidebarCollapse').on('click', function() {
                $('#sidebar').toggleClass('active');
            });

            // Activate current menu item
            const currentLocation = window.location.href;
            const menuItems = document.querySelectorAll('#sidebar a');
            menuItems.forEach(item => {
                if (currentLocation.includes(item.getAttribute('href'))) {
                    item.parentElement.classList.add('active');
                    const parent = item.closest('.collapse');
                    if (parent) {
                        parent.classList.add('show');
                    }
                }
            });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
</body>
</html>
