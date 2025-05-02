
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <label class="search-field-label">
        <span class="screen-reader-text"><?php echo _x( '検索:', 'label', 'my-knowledge-theme' ); ?></span>
        <input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'キーワードを入力...', 'placeholder', 'my-knowledge-theme' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( '検索キーワード', 'label', 'my-knowledge-theme' ); ?>" />
    </label>

    <div class="search-target-options">
        <span class="search-target-label"><?php _e( '検索対象:', 'my-knowledge-theme' ); ?></span>
        <label>
            <input type="radio" name="search_target" value="all" <?php checked( !isset($_GET['search_target']) || (isset($_GET['search_target']) && $_GET['search_target'] === 'all') ); ?>>
            <?php _e( 'すべて', 'my-knowledge-theme' ); ?>
        </label>
        <label>
            <input type="radio" name="search_target" value="knowledge_only" <?php checked( isset($_GET['search_target']) && $_GET['search_target'] === 'knowledge_only' ); ?>>
            <?php _e( 'ナレッジカードのみ', 'my-knowledge-theme' ); ?>
        </label>
    </div>

    <input type="submit" class="search-submit" value="<?php echo esc_attr_x( '検索', 'submit button', 'my-knowledge-theme' ); ?>" />
</form>
