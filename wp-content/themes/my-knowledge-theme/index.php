<?php get_header(); // header.php を読み込む ?>

<?php // ↓↓↓ ここから追加 ↓↓↓ ?>
<div class="content-area">
    <main class="site-main">
<?php // ↑↑↑ ここまで追加 ↑↑↑ ?>

        <?php if ( have_posts() ) : ?>
            <?php while ( have_posts() ) : the_post(); ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('post-summary index-item'); ?>>
                    <header class="entry-header">
                        <?php // タイトルを記事へのリンクにする ?>
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    </header>

                    <div class="entry-summary">
                        <?php the_excerpt(); // 抜粋を表示 ?>
                    </div>

                </article>

            <?php endwhile; ?>

            <?php
               // 投稿件数が多い場合にページネーションを表示
                the_posts_pagination( array(
                'prev_text' => __( '&laquo; 前へ', 'my-knowledge-theme' ),
                'next_text' => __( '次へ &raquo;', 'my-knowledge-theme' ),
                ) );
            ?>

        <?php else : ?>
            <p>投稿が見つかりませんでした。</p>
        <?php endif; ?>

<?php // ↓↓↓ ここから追加 ↓↓↓ ?>
    </main><!-- .site-main -->
</div><!-- .content-area -->
<?php // ↑↑↑ ここまで追加 ↑↑↑ ?>

<?php get_footer(); // footer.php を読み込む ?>
