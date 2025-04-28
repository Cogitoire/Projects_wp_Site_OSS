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
function my_theme_enqueue_styles() {

    // style.css をエンキューする
    wp_enqueue_style( 
        'my-theme-style', // スタイルのハンドル名（ユニークな名前）
        get_stylesheet_uri(), // テーマの style.css へのパスを取得する関数
        array(), // 依存関係 (もし他のCSSの後に読み込みたい場合などに指定) - 今回はなし
        wp_get_theme()->get('Version') // バージョン (style.css の Version を自動で使う) - キャッシュ対策
    );

    // 他に読み込みたいCSSファイルがあれば、ここに追加で wp_enqueue_style() を書く
    // 例: wp_enqueue_style('my-google-fonts', 'https://fonts.googleapis.com/css?...');

    // JavaScriptファイルを読み込みたい場合は wp_enqueue_script() を使う (後述)
}
function my_knowledge_theme_scripts() {
        // 既存の wp_enqueue_style などがあれば、それはそのまま残してください
    
        // 作成した random-background.js を読み込む
        wp_enqueue_script(
            'my-knowledge-theme-random-background', // スクリプトのハンドル名 (ユニークな名前)
            get_template_directory_uri() . '/js/random-background.js', // ファイルのパス
            array(), // 依存する他のスクリプト (今回はなし)
            '1.0',   // バージョン番号
            true     // true にすると </body> の直前で読み込まれる (推奨)
        );

}
// 'wp_enqueue_scripts' アクションフックに、上で定義した関数を紐付ける
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
add_action( 'wp_enqueue_scripts', 'my_knowledge_theme_scripts' );



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
