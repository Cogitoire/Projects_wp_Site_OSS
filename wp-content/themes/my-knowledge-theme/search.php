<?php get_header(); // header.php を読み込む ?>

<div class="content-area">
    <main class="site-main">
        <header class="page-header search-header">
            <h1 class="page-title">
                <?php
                /* translators: %s: search query. */
                printf( esc_html__( '検索結果: %s', 'my-knowledge-theme' ), '<span>' . get_search_query() . '</span>' );
                ?>
            </h1>
            <?php
            // 検索対象を表示 (任意)
            $search_target_display = isset( $_GET['search_target'] ) ? sanitize_text_field( $_GET['search_target'] ) : 'all';
            if ($search_target_display === 'knowledge_only') {
                echo '<p class="search-target-info">' . esc_html__( '対象: 知識カードのみ', 'my-knowledge-theme' ) . '</p>';
            } else {
                echo '<p class="search-target-info">' . esc_html__( '対象: すべて', 'my-knowledge-theme' ) . '</p>';
            }
            ?>
        </header><!-- .page-header -->

        <?php if ( have_posts() ) : ?>

            <?php // ↓↓↓ ループ開始 ↓↓↓ ?>
            <?php while ( have_posts() ) : the_post(); ?>

                <?php // ↓↓↓ ここに index.php からコピーした記事表示部分を追加・修正 ↓↓↓ ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('search-result-item'); // 検索結果用のクラスに変更 (任意) ?>>
                    <header class="entry-header">
                        <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

                        <?php // ↓↓↓ 投稿タイプ表示 (任意) ↓↓↓ ?>
                        <div class="entry-meta post-type-meta">
                            <?php
                            $post_type_obj = get_post_type_object( get_post_type() );
                            if ( $post_type_obj ) {
                                echo '<span class="post-type-label">' . esc_html( $post_type_obj->labels->singular_name ) . '</span>';
                            }
                            // 必要であれば投稿日なども表示
                            // echo ' <span class="post-date">' . get_the_date() . '</span>';
                            ?>
                        </div>
                        <?php // ↑↑↑ 投稿タイプ表示 (任意) ↑↑↑ ?>
                    </header>

                    <div class="entry-summary">
                        <?php the_excerpt(); // 抜粋を表示 ?>
                    </div>

                </article>
                <?php // ↑↑↑ 記事表示部分ここまで ↑↑↑ ?>

            <?php endwhile; // ← ★★★ ループの終了タグを追加 ★★★ ?>

            <?php
               // 投稿件数が多い場合にページネーションを表示
                the_posts_pagination( array(
                'prev_text' => __( '&laquo; 前へ', 'my-knowledge-theme' ),
                'next_text' => __( '次へ &raquo;', 'my-knowledge-theme' ),
                ) );
            ?>

        <?php else : // ← ★★★ ここが正しい else の位置 ★★★ ?>

            <section class="no-results not-found">
                <header class="page-header">
                    <h1 class="page-title"><?php esc_html_e( '何も見つかりませんでした', 'my-knowledge-theme' ); ?></h1>
                </header>
                <div class="page-content">
                    <p><?php esc_html_e( '申し訳ありませんが、検索条件に一致するものは見つかりませんでした。別のキーワードで再検索してみてください。', 'my-knowledge-theme' ); ?></p>
                    <?php
                        // 再度検索フォームを表示
                        get_search_form();
                    ?>
                </div><!-- .page-content -->
            </section><!-- .no-results -->

        <?php endif; // ← ★★★ if ( have_posts() ) の終了タグ ★★★ ?>

    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); // footer.php を読み込む ?>
