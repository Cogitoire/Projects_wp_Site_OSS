<?php get_header(); // header.php を読み込む ?>

<div class="content-area">
    <main class="site-main">

        <header class="page-header"> <?php // アーカイブページのヘッダー ?>
            <?php
            the_archive_title( '<h1 class="page-title">', '</h1>' ); 
            the_archive_description( '<div class="archive-description">', '</div>' );
            ?>
        </header><?php if ( have_posts() ) : // 表示すべき知識カードがあるかチェック ?>

            <div class="knowledge-card-archive"> <?php // 一覧全体を囲むラッパー（スタイリング用） ?>
            <?php
            // ループ開始
            while ( have_posts() ) :
                the_post(); 
            ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('knowledge-card-summary'); ?>> <?php // 各カードのラッパー ?>

                    <header class="entry-header">
                        <?php // ★★★ シンプルな方法でタイトルをリンクにする ★★★ ?>
                        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
                    </header><?php if ( has_post_thumbnail() ) : // アイキャッチ画像があるか？ ?>
                        <div class="post-thumbnail">
                            <?php // アイキャッチ画像も詳細ページへのリンクにする ?>
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('thumbnail'); // 'thumbnail' サイズで表示 ?>
                            </a>
                        </div><?php endif; ?>

                    <div class="entry-summary"> <?php // 抜粋文エリア ?>
                        <?php the_excerpt(); // 抜粋を表示 ?>
                    </div <footer class="entry-footer">
                        <div class="entry-meta">
                            <?php 
                            // 分野を表示
                            the_terms( get_the_ID(), 'field', '<span class="field-links">分野: ', ', ', '</span>' ); 

                            // ★★★ 分類を表示するコードを追加 ★★★
                            $classification_terms = get_the_terms( get_the_ID(), 'classification' );
                            if ( ! empty( $classification_terms ) && ! is_wp_error( $classification_terms ) ) {
                                echo ' <span class="meta-separator">|</span> '; // 区切り文字
                                the_terms( get_the_ID(), 'classification', '<span class="classification-links">分類: ', ', ', '</span>' );
                            }
                            ?>
                            <br> <?php // タグは改行して表示 ?>
                            <?php
                            // 知識タグを表示
                            the_terms( get_the_ID(), 'knowledge_tag', '<span class="knowledge-tag-links">タグ: ', ', ', '</span>' );
                            ?>
                        </div></footer></article><?php 
            endwhile; // ループ終了
            ?>
            </div><?php
            // ページネーション
            the_posts_pagination( array(
                'prev_text' => __( '&laquo; 前へ', 'my-knowledge-theme' ),
                'next_text' => __( '次へ &raquo;', 'my-knowledge-theme' ),
            ) );

        else : // 表示すべきカードが1件もなかった場合 ?>
            <p>該当する知識カードが見つかりませんでした。</p>
        <?php endif; ?>

    </main></div><?php get_footer(); // footer.php を読み込む ?>