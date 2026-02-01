<?php
require_once __DIR__ . '/../../lib/config.php';
$config = config();
?>
</div>
<footer>
    <div class="footer-inner">&copy; <?php echo htmlspecialchars($config['site']['title'], ENT_QUOTES, 'UTF-8'); ?></div>
</footer>
</body>
</html>
