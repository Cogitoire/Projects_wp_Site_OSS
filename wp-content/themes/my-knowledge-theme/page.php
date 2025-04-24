<?php get_header(); // header.php を読み込む ?>

<div class="content-area">
    <main class="site-main">

        <?php
        // ループ開始 (固定ページでもループは必要)
        while ( have_posts() ) :
            the_post();
        ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class('page-single'); // 固定ページ用のクラス ?>>
                <header class="entry-header">
                    <?php the_title( '<h1 class="entry-title">', '</h1>' ); // ページのタイトル ?>
                </header><?php if ( has_post_thumbnail() ) : // アイキャッチ画像 (固定ページでも使う場合) ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail(); ?>
                    </div><?php endif; ?>

                <div class="entry-content">
                    <?php the_content(); // 固定ページの本文 ?>
                    <?php
                    // ページが複数ページに分かれている場合のリンク (通常固定ページではあまり使わない)
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . __( 'Pages:', 'my-knowledge-theme' ),
                        'after'  => '</div>',
                    ) );
                    ?>
                </div><?php if ( get_edit_post_link() ) : // ログイン中に編集リンクを表示 (任意) ?>
                    <footer class="entry-footer">
                         <?php
                            edit_post_link(
                                sprintf(
                                    wp_kses(
                                        /* translators: %s: Name of current post. Only visible to screen readers */
                                        __( 'Edit <span class="screen-reader-text">%s</span>', 'my-knowledge-theme' ),
                                        array(
                                            'span' => array(
                                                'class' => array(),
                                            ),
                                        )
                                    ),
                                    get_the_title()
                                ),
                                '<span class="edit-link">',
                                '</span>'
                            );
                        ?>
                    </footer><?php endif; ?>
            </article><?php
            // 固定ページでコメントを許可する場合のみコメント欄を表示 (通常は許可しないことが多い)
            /*
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            */
            ?>

        <?php endwhile; // End of the loop. ?>

    </main></div><?php get_footer(); // footer.php を読み込む ?>