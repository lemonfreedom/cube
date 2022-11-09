</main>
<footer class="footer">
    <div class="container">
        <?php \Cube\Plugin::factory('admin/modules/footer.php')->test(1, 2, 3, 4) ?>
        <p><?= _t('由 <a href="/"><strong>Cube</strong></a> 强力驱动') ?></p>
    </div>
</footer>
<script src="/admin/scripts/js.cookie.min.js"></script>
<script src="/admin/scripts/index.js"></script>
</body>

</html>
