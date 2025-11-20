<?php
?>
<footer class="site-footer">
    <div class="container foot-min">
        <a class="brand-min" href="index.php">
            <span>🌱</span><strong>Plantou!</strong>
        </a>
        <div class="foot-meta">
            <span>© <span id="year"></span> Plantou! - Todos os direitos reservados</span>
        </div>
    </div>
</footer>
<script>
    document.getElementById('year').textContent = new Date().getFullYear();
</script>
