<?php // PHPコードを開始するおまじない (ファイルの先頭にこれ以外の文字や空白は入れない)

/**
 * テーマの基本設定
 */
function my_theme_setup() {
    // アイキャッチ画像を有効化
    add_theme_support( 'post-thumbnails' );

    // ★★★ ナビゲーションメニューを登録 ★★★
    register_nav_menus( array(
        'primary' => __( 'ヘッダーメニュー', 'my-knowledge-theme' ), // メニュー位置のスラッグ => 管理画面での表示名
        // 他にもメニュー位置が必要ならここに追加
    ) );

    // 他にテーマがサポートする機能があればここに追加
}
add_action( 'after_setup_theme', 'my_theme_setup' );

/**
 * テーマのスタイルシートとスクリプトを読み込む (エンキューする)
 */
/**
 * テーマのスタイルシートとスクリプトを読み込む (エンキューする)
 */
function my_theme_enqueue_scripts() { // ← この関数にまとめる

    // style.css をエンキューする
    wp_enqueue_style(
        'my-theme-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version')
    );

    // random-background.js を読み込む
    wp_enqueue_script(
        'my-knowledge-theme-random-background',
        get_template_directory_uri() . '/js/random-background.js',
        array(),
        '1.0',
        true
    );

    // ★★★ サイドバーフィルター用のJavaScriptを読み込む処理をここに追加 ★★★
    if ( is_post_type_archive('knowledge_card') || is_tax( get_object_taxonomies('knowledge_card') ) ) {
        wp_enqueue_script(
            'my-knowledge-sidebar-filter', // ハンドル名
            get_template_directory_uri() . '/js/sidebar-filter.js', // ファイルパス
            array('jquery'), // jQueryに依存
            '1.0', // バージョン
            true // フッターで読み込む
        );
    }
    // ★★★ ここまで追加 ★★★
}
// この関数を 'wp_enqueue_scripts' アクションにフックする
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_scripts' );




// ここから下に、他の関数や設定を追加していく

// ... (カスタム投稿タイプなどのコードはそのまま) ...


// ここから下に、他の関数や設定を追加していく


/**
 * カスタム投稿タイプ「知識カード」とカスタムタクソノミー「分野」「タグ」を登録する
 */
function my_theme_register_custom_types() {

    // カスタム投稿タイプ「知識カード」の登録
    $labels_knowledge_card = array(
        'name'                  => _x( '知識カード', 'Post type general name', 'my-knowledge-theme' ),
        'singular_name'         => _x( '知識カード', 'Post type singular name', 'my-knowledge-theme' ),
        'menu_name'             => _x( '知識カード', 'Admin Menu text', 'my-knowledge-theme' ),
        'name_admin_bar'        => _x( '知識カード', 'Add New on Toolbar', 'my-knowledge-theme' ),
        'add_new'               => __( '新規追加', 'my-knowledge-theme' ),
        'add_new_item'          => __( '新規知識カードを追加', 'my-knowledge-theme' ),
        'new_item'              => __( '新規知識カード', 'my-knowledge-theme' ),
        'edit_item'             => __( '知識カードを編集', 'my-knowledge-theme' ),
        'view_item'             => __( '知識カードを表示', 'my-knowledge-theme' ),
        'all_items'             => __( '知識カード一覧', 'my-knowledge-theme' ),
        'search_items'          => __( '知識カードを検索', 'my-knowledge-theme' ),
        'parent_item_colon'     => __( '親知識カード:', 'my-knowledge-theme' ),
        'not_found'             => __( '知識カードが見つかりませんでした。', 'my-knowledge-theme' ),
        'not_found_in_trash'    => __( 'ゴミ箱に知識カードが見つかりませんでした。', 'my-knowledge-theme' ),
        'featured_image'        => _x( 'アイキャッチ画像', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'my-knowledge-theme' ),
        'set_featured_image'    => _x( 'アイキャッチ画像を設定', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'my-knowledge-theme' ),
        'remove_featured_image' => _x( 'アイキャッチ画像を削除', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'my-knowledge-theme' ),
        'use_featured_image'    => _x( 'アイキャッチ画像として使用', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'my-knowledge-theme' ),
        'archives'              => _x( '知識カードアーカイブ', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'my-knowledge-theme' ),
        'insert_into_item'      => _x( '知識カードに挿入', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'my-knowledge-theme' ),
        'uploaded_to_this_item' => _x( 'この知識カードへのアップロード', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'my-knowledge-theme' ),
        'filter_items_list'     => _x( '知識カードリストを絞り込み', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'my-knowledge-theme' ),
        'items_list_navigation' => _x( '知識カードリストナビゲーション', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'my-knowledge-theme' ),
        'items_list'            => _x( '知識カードリスト', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'my-knowledge-theme' ),
    );
    $args_knowledge_card = array(
        'labels'             => $labels_knowledge_card,
        'public'             => true, // サイト上で公開する
        'has_archive'        => true, // アーカイブページ（一覧ページ）を持つ
        'publicly_queryable' => true,
        'show_ui'            => true, // 管理画面にUIを表示する
        'show_in_menu'       => true, // 管理画面のメニューに表示する
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'knowledge' ), // URLのスラッグ（例: http://localhost:8080/knowledge/カード名/）
        'capability_type'    => 'post',
        'hierarchical'       => false, // 階層構造を持たない（固定ページのような親子関係はなし）
        'menu_position'      => 5, // 管理画面メニューの表示位置（5は「投稿」の下あたり）
        'menu_icon'          => 'dashicons-book-alt', // 管理画面メニューのアイコン（Dashiconsから選択）
        'supports'           => array( 'title', 'editor', 'thumbnail' ), // サポートする機能（タイトル、本文エディタ、アイキャッチ画像）
        'show_in_rest'       => true, // ブロックエディタ（Gutenberg）に対応させる
    );
    register_post_type( 'knowledge_card', $args_knowledge_card ); // 'knowledge_card' という名前で登録
    

    // カスタムタクソノミー「分野」（カテゴリー形式）の登録
    $labels_field = array(
        'name'              => _x( '分野', 'taxonomy general name', 'my-knowledge-theme' ),
        'singular_name'     => _x( '分野', 'taxonomy singular name', 'my-knowledge-theme' ),
        'search_items'      => __( '分野を検索', 'my-knowledge-theme' ),
        'all_items'         => __( 'すべての分野', 'my-knowledge-theme' ),
        'parent_item'       => __( '親分野', 'my-knowledge-theme' ),
        'parent_item_colon' => __( '親分野:', 'my-knowledge-theme' ),
        'edit_item'         => __( '分野を編集', 'my-knowledge-theme' ),
        'update_item'       => __( '分野を更新', 'my-knowledge-theme' ),
        'add_new_item'      => __( '新規分野を追加', 'my-knowledge-theme' ),
        'new_item_name'     => __( '新規分野名', 'my-knowledge-theme' ),
        'menu_name'         => __( '分野', 'my-knowledge-theme' ),
    );
    $args_field = array(
        'hierarchical'      => true, // 階層構造を持つ（カテゴリーのように親子関係を作れる）
        'labels'            => $labels_field,
        'show_ui'           => true,
        'show_admin_column' => true, // 一覧画面にこのタクソノミーのカラムを表示する
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'field' ), // URLのスラッグ (例: http://localhost:8080/field/分野名/)
        'show_in_rest'      => true, // ブロックエディタ対応
    );
    register_taxonomy( 'field', array( 'knowledge_card' ), $args_field ); // 'field' という名前で 'knowledge_card' に紐付けて登録

    // カスタムタクソノミー「分類」（階層あり）の登録
    $labels_classification = array(
        'name'              => _x( '分類', 'taxonomy general name', 'my-knowledge-theme' ), // 管理画面での表示名
        'singular_name'     => _x( '分類', 'taxonomy singular name', 'my-knowledge-theme' ),
        'search_items'      => __( '分類を検索', 'my-knowledge-theme' ),
        'all_items'         => __( 'すべての分類', 'my-knowledge-theme' ),
        'parent_item'       => __( '親分類', 'my-knowledge-theme' ), // 階層ありなので親を指定できる
        'parent_item_colon' => __( '親分類:', 'my-knowledge-theme' ),
        'edit_item'         => __( '分類を編集', 'my-knowledge-theme' ),
        'update_item'       => __( '分類を更新', 'my-knowledge-theme' ),
        'add_new_item'      => __( '新規分類を追加', 'my-knowledge-theme' ),
        'new_item_name'     => __( '新規分類名', 'my-knowledge-theme' ),
        'menu_name'         => __( '分類', 'my-knowledge-theme' ), // メニュー名
    );
    $args_classification = array(
        'hierarchical'      => true, // ★★★ 階層構造を有効にする ★★★
        'labels'            => $labels_classification,
        'show_ui'           => true, // 管理画面に表示
        'show_admin_column' => true, // 知識カード一覧画面に「分類」カラムを表示（任意）
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'classification' ), // URLのスラッグ (例: /classification/産地/)
        'show_in_rest'      => true, // ブロックエディタ対応
    );
    // 'classification' という内部名で、'knowledge_card' 投稿タイプに紐付けて登録
    register_taxonomy( 'classification', array( 'knowledge_card' ), $args_classification ); 

    // カスタムタクソノミー「知識タグ」（タグ形式）の登録
    $labels_knowledge_tag = array(
        'name'                       => _x( '知識タグ', 'taxonomy general name', 'my-knowledge-theme' ),
        'singular_name'              => _x( '知識タグ', 'taxonomy singular name', 'my-knowledge-theme' ),
        'search_items'               => __( '知識タグを検索', 'my-knowledge-theme' ),
        'popular_items'              => __( 'よく使われている知識タグ', 'my-knowledge-theme' ),
        'all_items'                  => __( 'すべての知識タグ', 'my-knowledge-theme' ),
        'edit_item'                  => __( '知識タグを編集', 'my-knowledge-theme' ),
        'update_item'                => __( '知識タグを更新', 'my-knowledge-theme' ),
        'add_new_item'               => __( '新規知識タグを追加', 'my-knowledge-theme' ),
        'new_item_name'              => __( '新規知識タグ名', 'my-knowledge-theme' ),
        'separate_items_with_commas' => __( '知識タグはコンマ（,）で区切ってください', 'my-knowledge-theme' ),
        'add_or_remove_items'        => __( '知識タグを追加または削除', 'my-knowledge-theme' ),
        'choose_from_most_used'      => __( 'よく使われている知識タグから選択', 'my-knowledge-theme' ),
        'not_found'                  => __( '知識タグが見つかりませんでした。', 'my-knowledge-theme' ),
        'menu_name'                  => __( '知識タグ', 'my-knowledge-theme' ),
    );
    $args_knowledge_tag = array(
        'hierarchical'          => false, // 階層構造を持たない（タグ形式）
        'labels'                => $labels_knowledge_tag,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'knowledge-tag' ), // URLのスラッグ
        'show_in_rest'          => true, // ブロックエディタ対応
    );
    register_taxonomy( 'knowledge_tag', array( 'knowledge_card' ), $args_knowledge_tag ); // 'knowledge_tag' という名前で 'knowledge_card' に紐付けて登録

}
// WordPress の初期化時（'init' アクション）に上記の関数を実行するようにフックする
add_action( 'init', 'my_theme_register_custom_types' );
/** 抜粋の長さを変更する（デフォルトは55ワード）
 */
function my_theme_custom_excerpt_length( $length ) {
    return 45; // ★ ここで抜粋のワード数を調整（例: 40ワード）
}
add_filter( 'excerpt_length', 'my_theme_custom_excerpt_length', 999 );

/**
 * 抜粋の末尾の文字を変更する（[...] を ... + 続きを読むリンクに）
 */
function my_theme_custom_excerpt_more( $more ) {
    global $post;
    // return '...'; // 単に「...」だけ表示したい場合
    return '... <a class="read-more" href="'. esc_url( get_permalink($post->ID) ) . '">' . __( '続きを読む &raquo;', 'my-knowledge-theme' ) . '</a>'; // 続きを読むリンク付き
}
add_filter( 'excerpt_more', 'my_theme_custom_excerpt_more' );

/**
 * アーカイブページのタイトルから余計な文字（「アーカイブ:」など）を削除する
 */
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

// もし、さらにタイトルをカスタマイズしたい場合 (例: 「知識カード一覧」と表示)

function my_custom_archive_title( $title ) {
    if ( is_post_type_archive( 'knowledge_card' ) ) { // 知識カードのアーカイブの場合
        $title = '知識カード一覧'; // ★ 表示したいタイトルに変更
    } elseif ( is_tax( 'field' ) ) { // 分野タクソノミーのアーカイブの場合
        $title = single_term_title( '', false ) . ' の知識カード'; // 例:「建築 の知識カード」
    } elseif ( is_tax( 'classification' ) ) { // 分類タクソノミーのアーカイブの場合
        $title = single_term_title( '', false ) . ' の知識カード'; // 例:「ゴシック様式 の知識カード」
    }
    // 他のアーカイブ（カテゴリー、タグ、日付など）のタイトルも必要に応じてここで変更可能
    return $title;
}
add_filter( 'get_the_archive_title', 'my_custom_archive_title' );

/**
 * 検索クエリを変更して、カスタム投稿タイプを含めたり、対象を絞り込んだりする
 */
function my_knowledge_theme_search_filter( $query ) {
    // 管理画面の検索やメインクエリでない場合は何もしない
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    // 検索ページのクエリの場合
    if ( $query->is_search() ) {
        // ラジオボタンの値を取得 (なければ 'all' とする)
        $search_target = isset( $_GET['search_target'] ) ? sanitize_text_field( $_GET['search_target'] ) : 'all';

        if ( $search_target === 'knowledge_only' ) {
            // 「知識カードのみ」が選択された場合、投稿タイプを 'knowledge_card' に限定
            $query->set( 'post_type', 'knowledge_card' );
        } else {
            // 「すべて」が選択された場合 (または指定がない場合)
            // 検索対象に 'post' (投稿), 'page' (固定ページ), 'knowledge_card' (知識カード) を含める
            $query->set( 'post_type', array( 'post', 'page', 'knowledge_card' ) );
        }
    }
}
add_action( 'pre_get_posts', 'my_knowledge_theme_search_filter' );

/**
 * パンくずリスト生成関数
 */
function my_knowledge_theme_breadcrumbs() {
    // トップページでは何も表示しない
    if ( is_front_page() ) {
        return;
    }

    // パンくずリストのHTMLを格納する変数
    $breadcrumbs = '<nav class="breadcrumbs" aria-label="breadcrumb"><ol>'; // ol要素で開始

    // ホームへのリンクは常に表示
    $breadcrumbs .= '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'ホーム', 'my-knowledge-theme' ) . '</a></li>';

    // 区切り文字 (CSSで非表示にし、::before などで表示するのが一般的)
    $separator = '<span class="separator" aria-hidden="true"> &gt; </span>'; // 例: >

    // --- 各ページタイプごとの処理 ---

    // ブログ記事一覧ページ (ホームページ設定で固定ページ以外が選択されている場合)
    if ( is_home() && ! is_front_page() ) {
        $post_page_id = get_option( 'page_for_posts' );
        $breadcrumbs .= $separator . '<li>' . esc_html( get_the_title( $post_page_id ) ) . '</li>';
    }
    // 知識カードのアーカイブページ
    elseif ( is_post_type_archive( 'knowledge_card' ) ) {
        $breadcrumbs .= $separator . '<li>' . esc_html( post_type_archive_title( '', false ) ) . '</li>';
    }
    // カスタムタクソノミー (分野、分類、知識タグ) のアーカイブページ
    elseif ( is_tax( array( 'field', 'classification', 'knowledge_tag' ) ) ) {
        $term = get_queried_object();
        if ( $term ) {
            // 親タームがあれば遡って表示 (階層があるタクソノミー用)
            $ancestors = get_ancestors( $term->term_id, $term->taxonomy );
            $ancestors = array_reverse( $ancestors );
            foreach ( $ancestors as $ancestor_id ) {
                $ancestor = get_term( $ancestor_id, $term->taxonomy );
                if ( $ancestor && ! is_wp_error( $ancestor ) ) {
                    $breadcrumbs .= $separator . '<li><a href="' . esc_url( get_term_link( $ancestor ) ) . '">' . esc_html( $ancestor->name ) . '</a></li>';
                }
            }
            // 現在のターム名 (リンクなし)
            $breadcrumbs .= $separator . '<li>' . esc_html( $term->name ) . '</li>';
        }
    }
    // 通常の投稿アーカイブ (カテゴリー、タグ、日付など)
    elseif ( is_category() || is_tag() || is_date() || is_author() ) {
         $breadcrumbs .= $separator . '<li>' . get_the_archive_title() . '</li>'; // アーカイブタイトル
    }
    // 検索結果ページ
    elseif ( is_search() ) {
        $breadcrumbs .= $separator . '<li>' . sprintf( esc_html__( '検索結果: %s', 'my-knowledge-theme' ), '<span>' . get_search_query() . '</span>' ) . '</li>';
    }
    // 固定ページ
    elseif ( is_page() ) {
        $post = get_queried_object();
        if ( $post->post_parent ) { // 親ページがあれば遡って表示
            $ancestors = get_post_ancestors( $post->ID );
            $ancestors = array_reverse( $ancestors );
            foreach ( $ancestors as $ancestor_id ) {
                $breadcrumbs .= $separator . '<li><a href="' . esc_url( get_permalink( $ancestor_id ) ) . '">' . esc_html( get_the_title( $ancestor_id ) ) . '</a></li>';
            }
        }
        // 現在のページ名 (リンクなし)
        $breadcrumbs .= $separator . '<li>' . esc_html( get_the_title() ) . '</li>';
    }
    // 個別投稿ページ (知識カード、ブログ記事など)
    elseif ( is_singular() ) {
        $post = get_queried_object();
        $post_type = get_post_type( $post );

        // 知識カードの場合
        if ( $post_type === 'knowledge_card' ) {
            // 知識カードアーカイブへのリンク
            $post_type_obj = get_post_type_object( $post_type );
            if ( $post_type_obj && $post_type_obj->has_archive ) {
                $breadcrumbs .= $separator . '<li><a href="' . esc_url( get_post_type_archive_link( $post_type ) ) . '">' . esc_html( $post_type_obj->labels->archives ) . '</a></li>';
            }
            // ★★★ 分野や分類の階層を表示したい場合はここに追加 ★★★
            // 例: 主な分野を取得してリンクを追加
            $fields = get_the_terms( $post->ID, 'field' );
            if ( ! empty( $fields ) && ! is_wp_error( $fields ) ) {
                // 複数ある場合は最初のものを表示するなどのルール決めが必要
                $primary_field = $fields[0];
                // 親があれば表示
                $field_ancestors = get_ancestors( $primary_field->term_id, 'field' );
                $field_ancestors = array_reverse( $field_ancestors );
                foreach ( $field_ancestors as $ancestor_id ) {
                     $ancestor = get_term( $ancestor_id, 'field' );
                     if ( $ancestor && ! is_wp_error( $ancestor ) ) {
                         $breadcrumbs .= $separator . '<li><a href="' . esc_url( get_term_link( $ancestor ) ) . '">' . esc_html( $ancestor->name ) . '</a></li>';
                     }
                }
                $breadcrumbs .= $separator . '<li><a href="' . esc_url( get_term_link( $primary_field ) ) . '">' . esc_html( $primary_field->name ) . '</a></li>';
            }

        }
        // 通常の投稿 (ブログ記事) の場合
        elseif ( $post_type === 'post' ) {
            // カテゴリーを取得して表示 (複数ある場合は最初のものを表示)
            $categories = get_the_category( $post->ID );
            if ( ! empty( $categories ) ) {
                $primary_category = $categories[0];
                // 親カテゴリーがあれば表示
                $cat_ancestors = get_ancestors( $primary_category->term_id, 'category' );
                $cat_ancestors = array_reverse( $cat_ancestors );
                foreach ( $cat_ancestors as $ancestor_id ) {
                     $ancestor = get_category( $ancestor_id );
                     if ( $ancestor && ! is_wp_error( $ancestor ) ) {
                         $breadcrumbs .= $separator . '<li><a href="' . esc_url( get_category_link( $ancestor->term_id ) ) . '">' . esc_html( $ancestor->name ) . '</a></li>';
                     }
                }
                $breadcrumbs .= $separator . '<li><a href="' . esc_url( get_category_link( $primary_category->term_id ) ) . '">' . esc_html( $primary_category->name ) . '</a></li>';
            }
        }

        // 現在の投稿タイトル (リンクなし)
        $breadcrumbs .= $separator . '<li>' . esc_html( get_the_title() ) . '</li>';
    }
    // 404ページ
    elseif ( is_404() ) {
        $breadcrumbs .= $separator . '<li>' . esc_html__( '404 Not Found', 'my-knowledge-theme' ) . '</li>';
    }

    // --- 処理終了 ---

    $breadcrumbs .= '</ol></nav>'; // ol要素を閉じる

    // パンくずリストを出力
    echo $breadcrumbs;
}

/**
 * フィルター用ウィジェットエリアを登録
 */
function my_knowledge_theme_widgets_init() {
    register_sidebar( array(
        'name'          => __( '知識カードフィルター', 'my-knowledge-theme' ),
        'id'            => 'knowledge-filter-area', // ← ★★★ ここの ID を確認 ★★★
        'description'   => __( '知識カードアーカイブページに表示されるフィルターウィジェットを追加します。', 'my-knowledge-theme' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s filter-widget">', // ウィジェットのラッパー開始タグ
        'after_widget'  => '</section>', // ウィジェットのラッパー終了タグ
        'before_title'  => '<h2 class="widget-title">', // ウィジェットタイトルの開始タグ
        'after_title'   => '</h2>', // ウィジェットタイトルの終了タグ
    ) );
}
add_action( 'widgets_init', 'my_knowledge_theme_widgets_init' );
/**
 * タクソノミーフィルターウィジェットクラス
 */
class My_Knowledge_Taxonomy_Filter_Widget extends WP_Widget {

    // ウィジェット設定
    function __construct() {
        parent::__construct(
            'my_knowledge_taxonomy_filter_widget', // Base ID
            __( '知識カード タクソノミーフィルター', 'my-knowledge-theme' ), // Name
            array( 'description' => __( '指定したタクソノミーのタームをチェックボックスで表示し、知識カードを絞り込みます。', 'my-knowledge-theme' ), ) // Args
        );
    }

    // フロントエンド表示 (ウィジェットがサイドバーに表示される内容)
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'], $instance, $this->id_base );
        $taxonomy = isset( $instance['taxonomy'] ) ? $instance['taxonomy'] : '';
        // $relation はここでは使わない (クエリ変更は pre_get_posts で行うため)

        if ( empty( $taxonomy ) || ! taxonomy_exists( $taxonomy ) ) {
            return; // タクソノミーが指定されていないか存在しない場合は何もしない
        }

        // フォームの開始 (現在のURLを取得し、既存のGETパラメータを維持しつつ送信)
        $current_url = remove_query_arg( 'paged', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" );

        echo $args['before_widget']; // ウィジェット開始タグ
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . esc_html( $title ) . $args['after_title']; // ウィジェットタイトル
        }

        // タクソノミーのタームを取得
        $terms = get_terms( array(
            'taxonomy'   => $taxonomy,
            'hide_empty' => true, // 投稿がないタームは非表示
            'orderby'    => 'name', // 名前順で表示
            'order'      => 'ASC',
        ) );

        // タームが存在する場合のみフォームとリストを表示
        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {

            // 現在選択されているタームIDを取得 (GETパラメータから)
            $current_term_ids = isset( $_GET[ $taxonomy ] ) ? array_map( 'intval', (array) $_GET[ $taxonomy ] ) : array();

            echo '<form class="taxonomy-filter-form" method="get" action="' . esc_url( $current_url ) . '">';

            // --- 隠しフィールド ---
            // ページネーションとこのウィジェットのタクソノミー以外のGETパラメータを維持
            foreach ( $_GET as $key => $value ) {
                if ( $key !== 'paged' && $key !== $taxonomy ) {
                    if ( is_array( $value ) ) {
                        foreach ( $value as $v ) {
                            echo '<input type="hidden" name="' . esc_attr( $key ) . '[]" value="' . esc_attr( $v ) . '">';
                        }
                    } else {
                        echo '<input type="hidden" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '">';
                    }
                }
            }
            // --- 隠しフィールドここまで ---
            // ★★★ ここから追加: リアルタイム検索ボックス ★★★
            echo '<div class="filter-search-wrapper">'; // 検索ボックス用のラッパー
            echo '<input type="text" class="filter-search-input" placeholder="' . esc_attr__( '項目を検索...', 'my-knowledge-theme' ) . '" aria-label="' . esc_attr__( 'フィルター項目を検索', 'my-knowledge-theme' ) . '" data-filter-target="#' . esc_attr($args['widget_id']) . ' .taxonomy-filter-list">';
            echo '</div>';
            // ★★★ ここまで追加 ★★★
 
            // リストに付与するクラスを決定
            $list_class = 'taxonomy-filter-list'; // 基本クラス
            if ( $taxonomy === 'field' ) {
                $list_class .= ' no-toggle'; // ★ 分野 ('field') の場合に 'no-toggle' クラスを追加
            }
            echo '<ul class="' . esc_attr( $list_class ) . '">'; // クラスを出力してリスト開始

                    // ★★★ ここから修正 ★★★
            foreach ( $terms as $term ) {
                $checked = in_array( $term->term_id, $current_term_ids ) ? ' checked' : '';
                echo '<li>';
                echo '<label>';
                echo '<input type="checkbox" name="' . esc_attr( $taxonomy ) . '[]" value="' . esc_attr( $term->term_id ) . '"' . $checked . '>';
                echo ' ' . esc_html( $term->name ) . ' (' . esc_html( $term->count ) . ')'; // ターム名と投稿数を表示
                echo '</label>';
                echo '</li>';
            }
            echo '</ul>'; // リスト終了

            if ( $taxonomy !== 'field' ) {
                // もっと見るボタン
                echo '<button type="button" class="toggle-visibility-button" data-target-list="#' . esc_attr($args['widget_id']) . ' .taxonomy-filter-list">' . __('もっと見る', 'my-knowledge-theme') . '</button>';
            }

         // 絞り込みボタン
            echo '<button type="submit" class="filter-submit-button">' . __( '絞り込む', 'my-knowledge-theme' ) . '</button>';
            echo '</form>'; // フォーム終了

        } else { // タームが見つからなかった場合
            echo '<p>' . esc_html__( '利用可能なフィルター項目がありません。', 'my-knowledge-theme' ) . '</p>';
        }

        echo $args['after_widget']; // ウィジェット終了タグ
    } // widget メソッドの閉じ括弧


    // バックエンド (管理画面でのウィジェット設定フォーム)
    public function form( $instance ) {
        $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
        $taxonomy = ! empty( $instance['taxonomy'] ) ? $instance['taxonomy'] : '';
        $relation = ! empty( $instance['relation'] ) ? $instance['relation'] : 'AND';

        // 利用可能なタクソノミーを取得 (知識カードに紐づくもの)
        $taxonomies = get_object_taxonomies( 'knowledge_card', 'objects' );
        ?>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'タイトル:', 'my-knowledge-theme' ); ?></label>
            <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php esc_attr_e( '対象タクソノミー:', 'my-knowledge-theme' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>">
                <option value=""><?php esc_html_e( '-- 選択してください --', 'my-knowledge-theme' ); ?></option>
                <?php foreach ( $taxonomies as $tax ) : ?>
                    <?php if ( $tax->public && $tax->show_ui ) : // 公開されていてUIを持つもののみ ?>
                        <option value="<?php echo esc_attr( $tax->name ); ?>" <?php selected( $taxonomy, $tax->name ); ?>>
                            <?php echo esc_html( $tax->label ); ?> (<?php echo esc_html( $tax->name ); ?>)
                        </option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </p>
         <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'relation' ) ); ?>"><?php esc_attr_e( '複数選択時の条件:', 'my-knowledge-theme' ); ?></label>
            <select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'relation' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'relation' ) ); ?>">
                <option value="AND" <?php selected( $relation, 'AND' ); ?>><?php esc_html_e( 'AND (すべて満たす)', 'my-knowledge-theme' ); ?></option>
                <option value="OR" <?php selected( $relation, 'OR' ); ?>><?php esc_html_e( 'OR (いずれかを満たす)', 'my-knowledge-theme' ); ?></option>
            </select>
             <small><?php esc_html_e( '同じタクソノミー内で複数チェックした場合の条件です。', 'my-knowledge-theme' ); ?></small>
        </p>
        <?php
    }

    // ウィジェット設定の更新
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
        $instance['taxonomy'] = ( ! empty( $new_instance['taxonomy'] ) ) ? sanitize_text_field( $new_instance['taxonomy'] ) : '';
        $instance['relation'] = ( isset( $new_instance['relation'] ) && $new_instance['relation'] === 'OR' ) ? 'OR' : 'AND';
        return $instance;
    }
}

// ウィジェットを登録する関数
function register_my_knowledge_filter_widget() {
    register_widget( 'My_Knowledge_Taxonomy_Filter_Widget' );
}
add_action( 'widgets_init', 'register_my_knowledge_filter_widget' );

/**
 * 知識カード一覧でタクソノミーフィルターを適用する
 */
function my_knowledge_theme_filter_query( $query ) {
    // 管理画面やメインクエリでない場合、または知識カード関連のアーカイブでない場合は何もしない
    if ( is_admin() || ! $query->is_main_query() ||
         ! ( $query->is_post_type_archive( 'knowledge_card' ) || $query->is_tax( get_object_taxonomies( 'knowledge_card' ) ) )
       ) {
        return;
    }

    // 既存の tax_query を取得 (あれば)
    $tax_query = $query->get( 'tax_query' ) ?: array();

    // フィルター対象のタクソノミーリスト
    $filter_taxonomies = array( 'field', 'classification', 'knowledge_tag' );

    // 各タクソノミーについてGETパラメータを確認
    foreach ( $filter_taxonomies as $taxonomy ) {
        if ( isset( $_GET[ $taxonomy ] ) && is_array( $_GET[ $taxonomy ] ) ) {
            $term_ids = array_map( 'intval', $_GET[ $taxonomy ] );
            if ( ! empty( $term_ids ) ) {
                // ウィジェット設定から relation を取得 (デフォルトは AND)
                // ※ 簡単のため、ここでは常に AND/OR を固定で指定するか、
                //   ウィジェットごとに設定した relation を取得する仕組みが必要。
                //   今回はシンプルに AND で実装します。OR にしたい場合は 'OR' に変更。
                $relation = 'AND'; // または 'OR'

                $tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $term_ids,
                    'operator' => $relation, // 同じタクソノミー内での条件 (AND: 全て含む, OR: いずれかを含む)
                );
            }
        }
    }

    // 複数のタクソノミー間での条件 (AND: すべてのタクソノミー条件を満たす)
    if ( count( $tax_query ) > 1 ) {
        $tax_query['relation'] = 'AND';
    }

    // 変更した tax_query をセット
    if ( ! empty( $tax_query ) ) {
        $query->set( 'tax_query', $tax_query );
    }
}
add_action( 'pre_get_posts', 'my_knowledge_theme_filter_query' );