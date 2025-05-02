<?php get_header(); // header.php を読み込む ?>

<?php // ★★★ #content は header.php の最後で開始し、footer.php の最初で閉じるのが一般的 ★★★ ?>
<?php // ★★★ header.php と footer.php を確認してください ★★★ ?>
<?php // ★★★ ここでは #content が正しく配置されている前提で進めます ★★★ ?>

<?php
// パンくずリストは #content の直下、メインラッパーの外に配置するのが一般的
// header.php またはこのファイルの #content のすぐ下あたりに移動を検討
// if ( function_exists( 'my_knowledge_theme_breadcrumbs' ) ) {
//     my_knowledge_theme_breadcrumbs();
// }
?>

<?php // --- サイドバーありレイアウト (Flexboxラッパー) --- ?>
<div class="content-wrapper-flex"> <?php // ← Flexboxコンテナ ?>

    <main id="primary" class="content-area with-sidebar"> <?php // ← メインコンテンツエリア (Flexアイテム1) ?>
            <header class="page-header"> <?php // アーカイブページのヘッダー ?>
                <?php
                the_archive_title( '<h1 class="page-title">', '</h1>' );
                the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
            </header>
            <?php // フォームはサイドバーに移動 ?>

            <?php // --- 件数表示 ---
            global $wp_query; // メインクエリの情報を取得
            $found_posts = $wp_query->found_posts; // 見つかった投稿の総数
            echo '<p class="knowledge-card-count">' . esc_html( $found_posts ) . ' 件のナレッジカードが見つかりました。</p>';
            ?>
            
            <?php if ( have_posts() ) : // 表示すべきナレッジカードがあるかチェック ?>

                <div class="knowledge-card-archive"> <?php // 一覧全体を囲むラッパー ?>
                <?php
                // ループ開始
                while ( have_posts() ) :
                    the_post();
                ?>
                    <article id="post-<?php the_ID(); ?>" <?php post_class('knowledge-card-summary'); ?>> <?php // 各カード ?>
                        <header class="entry-header">
                            <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        </header>
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="entry-summary">
                            <?php the_excerpt(); ?>
                        </div>
                        <footer class="entry-footer">
                            <div class="entry-meta">
                                <?php
                                the_terms( get_the_ID(), 'field', '<span class="field-links">分野: ', ', ', '</span>' );
                                $classification_terms = get_the_terms( get_the_ID(), 'classification' );
                                if ( ! empty( $classification_terms ) && ! is_wp_error( $classification_terms ) ) {
                                    echo ' <span class="meta-separator">|</span> ';
                                    the_terms( get_the_ID(), 'classification', '<span class="classification-links">分類: ', ', ', '</span>' );
                                }
                                ?>
                                <br>
                                <?php
                                the_terms( get_the_ID(), 'knowledge_tag', '<span class="knowledge-tag-links">タグ: ', ', ', '</span>' );
                                ?>
                            </div>
                        </footer>
                    </article>
                <?php
                endwhile; // ループ終了
                ?>
                </div><?php // .knowledge-card-archive ?>

                <?php
                // ページネーション
                the_posts_pagination( array(
                    'prev_text' => __( '&laquo; 前へ', 'my-knowledge-theme' ),
                    'next_text' => __( '次へ &raquo;', 'my-knowledge-theme' ),
                ) );

            else : // 表示すべきカードが1件もなかった場合 ?>
                <p>該当するナレッジカードが見つかりませんでした。</p>
            <?php endif; // have_posts() ?>

        </main><!-- #primary -->
        
        <?php get_sidebar('knowledge-filter'); // ← サイドバー (Flexアイテム2) ?>


</div><!-- .content-wrapper-flex -->

<?php // 不要なコメントは削除 ?>

<?php get_footer(); // footer.php を読み込む ?>
