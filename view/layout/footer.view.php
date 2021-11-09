<footer>
    <p class="copyright">© 2020 Grimm Photography</p>
</footer>
<script>
    @@scripts
    var loaded = 0;
    var app;
    scripts.forEach(function(s) {
        var node = document.createElement("script");
        node.src = "@@baseUrl/js/" + s;
        document.head.appendChild(node);
        node.onload = function() {
            loaded++;
            if (loaded == scripts.length) {
                app = new App();
            }
        }
    });
</script>
