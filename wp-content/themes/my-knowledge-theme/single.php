<?php get_header(); // header.php を読み込む ?>

<div class="content-area">
    <main class="site-main">

        <?php
        // WordPressループ開始 
        if ( have_posts() ) :
            while ( have_posts() ) : the_post(); 
        ?>

                <article id="post-<?php the_ID(); ?>" <?php post_class('post-single'); // CSS用にクラス追加 ?>>

                    <header class="entry-header">
                        <?php the_title( '<h1 class="entry-title">', '</h1>' ); // 記事タイトル ?>
                        <div class="entry-meta"> <?php // 投稿メタ情報 ?>
                            <span>投稿日: <?php the_date(); ?></span> | 
                            <span>作成者: <?php the_author(); ?></span> 
                            <?php 
                            // カテゴリーやタグも表示する場合の例
                            echo ' | カテゴリー: ';
                            the_category(', '); 
                            the_tags(' | タグ: ', ', ');
                            ?>
                        </div></header><?php if ( has_post_thumbnail() ) : // アイキャッチ画像 ?>
                        <div class="post-thumbnail">
                            <?php the_post_thumbnail(); ?>
                        </div><?php endif; ?>

                    <div class="entry-content"> <?php // 本文エリア ?>
                        <?php the_content(); // ★★★ これが本文を表示する重要な関数です ★★★ ?>
                    </div><footer class="entry-footer"> 
                        <?php // 記事フッター（必要なら何か追加） ?>
                    </footer><?php
                    // コメント欄を表示 (もしコメントが許可されていれば)
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                    ?>

                </article><?php 
            endwhile; // ループ終了
        endif; 
        ?>
        
    </main><!-- .site-main -->
</div><!-- .content-area -->

<?php get_footer(); // footer.php を読み込む ?>