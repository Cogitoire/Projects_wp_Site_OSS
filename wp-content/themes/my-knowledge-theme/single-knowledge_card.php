<?php get_header(); // header.php を読み込む ?>

<div class="content-area">
    <main class="site-main">

        <?php
        if ( have_posts() ) :
            while ( have_posts() ) : the_post(); 
        ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class('knowledge-card-single'); ?>>
                    
                    <?php // ★★ 全体を囲むコンテナを追加 ★★ ?>
                    <div class="knowledge-card-container"> 

                        <?php // ★★ 左カラム (メインコンテンツ) ★★ ?>
                        <div class="knowledge-card-main-content">
                            
                            <header class="entry-header">
                                <?php the_title( '<h1 class="entry-title">', '</h1>' ); // タイトル ?>
                                <div class="entry-meta">
                                    <?php 
                                    // 分野をタイトルと本文の間に表示 (優先度高)
                                    the_terms( get_the_ID(), 'field', '<span class="field-links">分野: ', ', ', '</span>' ); 

                                    // ★★★ 分類を表示するコードを追加 ★★★
                                    // まず、分類タームが存在するか確認
                                    $classification_terms = get_the_terms( get_the_ID(), 'classification' );
                                    // 分類タームが存在する場合のみ、区切り文字と分類タームを表示
                                    if ( ! empty( $classification_terms ) && ! is_wp_error( $classification_terms ) ) {
                                        echo ' <span class="meta-separator">|</span> '; // 区切り文字（例: | ）
                                        the_terms( get_the_ID(), 'classification', '<span class="classification-links">分類: ', ', ', '</span>' );
                                        }                    
                                    ?>
                                    <?php // 必要であれば投稿日などもここに追加 ?>
                                </div></header><div class="entry-content">
                                <?php the_content(); // 本文 ?>
                            </div><footer class="entry-footer">
                                <div class="entry-meta">
                                     <?php
                                    // タグを本文の下に表示
                                    the_terms( get_the_ID(), 'knowledge_tag', '<span class="knowledge-tag-links">タグ: ', ', ', '</span>' );
                                    ?>
                                </div></footer></div><?php // ★★ 右カラム (サイドバー / 画像) ★★ ?>
                        <aside class="knowledge-card-sidebar">
                            <?php if ( has_post_thumbnail() ) : // アイキャッチ画像がある場合のみ表示 ?>
                                <div class="post-thumbnail">
                                    <?php the_post_thumbnail('large'); // 少し大きめの画像サイズを指定 (他に medium, full など) ?>
                                </div><?php endif; ?>
                            <?php // 画像がない場合はこの aside は空になるが、レイアウトは維持される ?>
                        </aside></div></article><?php 
            endwhile; 
        else : 
        ?>
            <p>該当する知識カードが見つかりませんでした。</p>
        <?php
        endif; 
        ?>

    </main></div><?php get_footer(); // footer.php を読み込む ?>