<?php
/**
 * ナレッジカード絞り込み用サイドバー
 *
 * @package My_Knowledge_Theme
 */
?>

<aside id="secondary" class="widget-area knowledge-filter-sidebar"> <?php // サイドバー全体のラッパー ?>

    <?php // --- 絞り込みフォーム --- ?>
    <div class="knowledge-card-filter-form">
        <form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'knowledge_card' ) ); ?>">
            <h3>絞り込み検索</h3>

            <?php
            // 現在選択されている値を取得 (フォームの初期状態設定用)
            $selected_fields = isset( $_GET['field'] ) ? array_map( 'sanitize_key', (array) $_GET['field'] ) : array();
            $selected_classifications = isset( $_GET['classification'] ) ? array_map( 'sanitize_key', (array) $_GET['classification'] ) : array();
            $selected_tags = isset( $_GET['knowledge_tag'] ) ? array_map( 'sanitize_key', (array) $_GET['knowledge_tag'] ) : array();

            // --- 分野 (field) ---
            $fields = get_terms( array( 'taxonomy' => 'field', 'hide_empty' => true ) ); // 投稿がないタームは非表示 (true)
            if ( ! empty( $fields ) && ! is_wp_error( $fields ) ) : ?>
                <fieldset class="filter-group filter-group-field filter-collapsible"> <?php // filter-collapsible クラスを追加 ?>
                    <legend class="filter-legend-toggle">分野:</legend> <?php // filter-legend-toggle クラスを追加 ?>
                    <div class="filter-controls"> <?php // 検索フィールドとオプションを囲むラッパー ?>
                        <input type="text" class="filter-search-input" placeholder="分野を検索...">
                        <div class="filter-options" style="display: none;"> <?php // 最初は非表示 ?>
                        <?php foreach ( $fields as $term ) : ?>
                             <label>
                                <input type="checkbox" name="field[]" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( in_array( $term->slug, $selected_fields ) ); ?>>
                                <?php echo esc_html( $term->name ); ?>
                            </label>
                        <?php endforeach; ?>
                        </div> <?php // .filter-options ?>
                    </div> <?php // .filter-controls ?>
                </fieldset>
            <?php endif; ?>

            <?php // --- 分類 (classification) ---
            $classifications = get_terms( array( 'taxonomy' => 'classification', 'hide_empty' => true ) );
            if ( ! empty( $classifications ) && ! is_wp_error( $classifications ) ) : ?>
                <fieldset class="filter-group filter-group-classification filter-collapsible"> <?php // filter-collapsible クラスを追加 ?>
                    <legend class="filter-legend-toggle">分類:</legend> <?php // filter-legend-toggle クラスを追加 ?>
                    <div class="filter-controls"> <?php // 検索フィールドとオプションを囲むラッパー ?>
                        <input type="text" class="filter-search-input" placeholder="分類を検索...">
                        <div class="filter-options" style="display: none;"> <?php // 最初は非表示 ?>
                        <?php foreach ( $classifications as $term ) : ?>
                            <label>
                                <input type="checkbox" name="classification[]" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( in_array( $term->slug, $selected_classifications ) ); ?>>
                                <?php echo esc_html( $term->name ); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    </div> <?php // .filter-controls ?>
                </fieldset>
            <?php endif; ?>

            <?php // --- 知識タグ (knowledge_tag) ---
            $tags = get_terms( array( 'taxonomy' => 'knowledge_tag', 'hide_empty' => true ) );
            if ( ! empty( $tags ) && ! is_wp_error( $tags ) ) : ?>
                <fieldset class="filter-group filter-group-knowledge_tag filter-collapsible"> <?php // filter-collapsible クラスを追加 ?>
                    <legend class="filter-legend-toggle">知識タグ:</legend> <?php // filter-legend-toggle クラスを追加 ?>
                    <div class="filter-controls"> <?php // 検索フィールドとオプションを囲むラッパー ?>
                        <input type="text" class="filter-search-input" placeholder="タグを検索...">
                        <div class="filter-options" style="display: none;"> <?php // 最初は非表示 ?>
                        <?php foreach ( $tags as $term ) : ?>
                            <label>
                                <input type="checkbox" name="knowledge_tag[]" value="<?php echo esc_attr( $term->slug ); ?>" <?php checked( in_array( $term->slug, $selected_tags ) ); ?>>
                                <?php echo esc_html( $term->name ); ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    </div> <?php // .filter-controls ?>
                </fieldset>
            <?php endif; ?>

            <div class="filter-actions">
                <button type="submit">絞り込む</button>
                <a href="<?php echo esc_url( get_post_type_archive_link( 'knowledge_card' ) ); ?>" class="filter-reset">リセット</a>
            </div>
        </form>
    </div>
    <?php // --- 絞り込みフォーム ここまで --- ?>

</aside><!-- #secondary -->