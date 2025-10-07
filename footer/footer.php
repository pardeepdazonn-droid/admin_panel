<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
    crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {
        $('.load-content').click(function (e) {
            e.preventDefault();
            let page = $(this).data('page');

            $('#main-content').load(page, function (response, status, xhr) {
                if (status == "error") {
                    $('#main-content').html("<p>Error loading content.</p>");
                }
            });
        });
    });
</script>

<script src="js/deletion.js"></script>
</body>

</html>