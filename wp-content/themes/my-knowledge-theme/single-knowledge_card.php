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
                                <?php // ★★★ ここから関連ナレッジカード表示コード ★★★ ?>
                                <?php
                                // --- 関連ナレッジカードの表示 ---

                                // 現在の投稿のIDを取得
                                $current_post_id = get_the_ID();

                                // 現在の投稿についている knowledge_tag を取得
                                $tags = get_the_terms( $current_post_id, 'knowledge_tag' );

                                // タグが存在する場合のみ処理
                                if ( $tags && ! is_wp_error( $tags ) ) {

                                    // タグIDのリストを作成
                                    $tag_ids = wp_list_pluck( $tags, 'term_id' );

                                    // 関連カードを取得するためのクエリ引数
                                    $related_args = array(
                                        'post_type'      => 'knowledge_card', // 投稿タイプを指定
                                        'tax_query'      => array(
                                            array(
                                                'taxonomy' => 'knowledge_tag', // タクソノミーを指定
                                                'field'    => 'term_id',
                                                'terms'    => $tag_ids,      // 現在の投稿と同じタグを持つ
                                            ),
                                        ),
                                        'post__not_in'   => array( $current_post_id ), // 現在の投稿を除外
                                        'posts_per_page' => 5,                      // ★表示件数 (お好みで変更: 3とかでもOK)
                                        'orderby'        => 'rand',                 // ★ランダム表示 (日付順なら 'date')
                                        'ignore_sticky_posts' => 1,                 // 先頭固定表示を無視
                                    );

                                    // クエリを実行
                                    var_dump($related_query);
// または、デバッグログに出力する場合
// error_log(print_r($args, true));

                                    $related_query = new WP_Query( $related_args );

                                    // 関連カードが見つかった場合
                                    if ( $related_query->have_posts() ) :
                                ?>
                                        <div class="related-knowledge-cards"> <?php // CSS用のクラス ?>
                                            <h3 class="related-title"><?php _e( '関連するナレッジカード', 'my-knowledge-theme' ); // 見出し ?></h3>
                                            <ul>
                                                <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                                                    <li>
                                                        <a href="<?php the_permalink(); ?>"><?php the_title(); // 関連カードのタイトルとリンク ?></a>
                                                        <?php // ★★★ ここから共通タグ表示コード ★★★ ?>
                                                        <?php
                                                        // 現在ループ中の関連カードのIDを取得
                                                        $related_post_id = get_the_ID();
                                                        // 現在ループ中の関連カードの knowledge_tag を取得
                                                        $related_tags = get_the_terms( $related_post_id, 'knowledge_tag' );

                                                        // 関連カードにもタグがあり、エラーでない場合
                                                        if ( $related_tags && ! is_wp_error( $related_tags ) ) {
                                                            // 関連カードのタグIDリストを作成
                                                            $related_tag_ids = wp_list_pluck( $related_tags, 'term_id' );

                                                            // ★★★ 現在のカードのタグIDリスト($tag_ids)と関連カードのタグIDリスト($related_tag_ids)の共通項を取得 ★★★
                                                            // $tag_ids はこのコードブロックの外側（関連カード検索前）で定義されています
                                                            $common_tag_ids = array_intersect( $tag_ids, $related_tag_ids );

                                                            // 共通タグが存在する場合
                                                            if ( ! empty( $common_tag_ids ) ) {
                                                                $common_tag_names = array();
                                                                // 共通タグIDからタグ名を取得し、リンク付きで配列に入れる
                                                                foreach ( $common_tag_ids as $common_tag_id ) {
                                                                    $term = get_term( $common_tag_id, 'knowledge_tag' );
                                                                    if ( $term && ! is_wp_error( $term ) ) {
                                                                        // タグ名をクリックするとそのタグのアーカイブページに飛ぶようにリンクを付ける
                                                                        $common_tag_names[] = '<a href="' . esc_url( get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a>';
                                                                        // ※ もしリンクが不要なら下の行を使う
                                                                        // $common_tag_names[] = esc_html( $term->name );
                                                                    }
                                                                }
                                                                // 共通タグ名をカンマ区切りで表示
                                                                if ( ! empty( $common_tag_names ) ) {
                                                                    // 見た目を調整するための span タグで囲む
                                                                    echo ' <span class="common-tags">(共通タグ: ' . implode( ', ', $common_tag_names ) . ')</span>';
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <?php // ★★★ ここまで共通タグ表示コード ★★★ ?>

                                                    </li>
                                                <?php endwhile; ?>
                                            </ul>
                                        </div>
                                <?php
                                    endif;

                                    // クエリのリセット (重要！)
                                    wp_reset_postdata();
                                } // endif $tags

                                // --- 関連ナレッジカードの表示 ここまで ---
                                ?>
                                <?php // ★★★ ここまで関連ナレッジカード表示コード ★★★ ?>

                        </aside></div></article><?php 
            endwhile; 
        else : 
        ?>
            <p>該当するナレッジカードが見つかりませんでした。</p>
        <?php
        endif; 
        ?>

    </main></div><?php get_footer(); // footer.php を読み込む ?>