<?php // ↑↑↑ メインコンテンツ部分を囲む終了タグ ↑↑↑ ?>
</div><!-- #content -->

<footer class="site-footer"> <?php // 例としてfooterタグで囲む ?>
    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo( 'name' ); ?></p>
</footer>

<?php wp_footer(); // 必須！ ?>
</body>
</html>