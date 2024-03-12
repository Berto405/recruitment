<!-- Bootstrap JS - CDN Link -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<!-- JQuery JS - CDN Link -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js""></script>

<!-- Summernote JS - CDN Link -->
<script src=" https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function () {
        $(".summernote").summernote({
            toolbar: [
                // Define your desired toolbar options here
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
            ]
        });
        $('.dropdown-toggle').dropdown();
    });
</script>