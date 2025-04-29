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

<?php // --- サイドバーを表示するかどうかで分岐 --- ?>
<?php if ( is_post_type_archive('knowledge_card') || is_tax( get_object_taxonomies('knowledge_card') ) ) : // 知識カードアーカイブまたは関連タクソノミーの場合 ?>

    <?php // --- サイドバーありレイアウト (Flexboxラッパー) --- ?>
    <div class="content-wrapper-flex"> <?php // ← Flexboxコンテナ ?>

        <main id="primary" class="content-area with-sidebar"> <?php // ← メインコンテンツエリア (Flexアイテム1) ?>
            <header class="page-header"> <?php // アーカイブページのヘッダー ?>
                <?php
                the_archive_title( '<h1 class="page-title">', '</h1>' );
                the_archive_description( '<div class="archive-description">', '</div>' );
                ?>
            </header>

            <?php if ( have_posts() ) : // 表示すべき知識カードがあるかチェック ?>

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
                <p>該当する知識カードが見つかりませんでした。</p>
            <?php endif; // have_posts() ?>

        </main><!-- #primary -->

        <?php get_sidebar('knowledge-filter'); // ← サイドバー (Flexアイテム2) - 正しい名前で呼び出す ?>

    </div><!-- .content-wrapper-flex -->

<?php else : // --- サイドバーなしレイアウト --- ?>

    <main id="primary" class="content-area"> <?php // ← サイドバーなしのメインコンテンツエリア ?>
        <header class="page-header"> <?php // アーカイブページのヘッダー ?>
            <?php
            the_archive_title( '<h1 class="page-title">', '</h1>' );
            the_archive_description( '<div class="archive-description">', '</div>' );
            ?>
        </header>

        <?php if ( have_posts() ) : ?>
            <div class="knowledge-card-archive"> <?php // スタイル適用のためクラスは残す ?>
            <?php while ( have_posts() ) : the_post(); ?>
                 <article id="post-<?php the_ID(); ?>" <?php post_class('knowledge-card-summary'); ?>>
                    <?php // サイドバーありと同じ表示内容をここに入れる (省略) ?>
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
            <?php endwhile; ?>
            </div>
            <?php the_posts_pagination(); ?>
        <?php else : ?>
            <p>該当する知識カードが見つかりませんでした。</p>
        <?php endif; ?>
    </main><!-- #primary -->

<?php endif; // is_post_type_archive or is_tax ?>

<?php // ★★★ 不要なラッパーやサイドバー呼び出しは削除 ★★★ ?>
<?php // <div class="main-content-wrapper clearfix"> ... </div> は削除 ?>
<?php // get_sidebar( 'knowledge' ); は削除 (意図して使っているなら別) ?>
<?php // <div id="content" ...> も削除 (header.php/footer.phpで管理) ?>

<?php get_footer(); // footer.php を読み込む ?>
