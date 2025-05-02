<?php
/**
 * Cogitoire Knowledge Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package My_Knowledge_Theme
 */

// =========================================================================
// 1. テーマ基本設定
// =========================================================================
function my_knowledge_theme_setup() {
    // アイキャッチ画像の有効化
    add_theme_support( 'post-thumbnails' );

    // ナビゲーションメニューの登録
    register_nav_menus( array(
        'primary' => __( 'ヘッダーメニュー', 'my-knowledge-theme' ),
    ) );

    // HTML5のサポート (推奨)
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ) );

    // タイトルタグのサポート (必須)
    add_theme_support( 'title-tag' );

    // 自動フィードリンク (推奨)
    add_theme_support( 'automatic-feed-links' );

    // 翻訳ファイルの読み込み (必要なら)
    // load_theme_textdomain( 'my-knowledge-theme', get_template_directory() . '/languages' );
}
add_action( 'after_setup_theme', 'my_knowledge_theme_setup' );

// =========================================================================
// 2. スクリプト・スタイルの読み込み
// =========================================================================
function my_knowledge_theme_enqueue_scripts() {
    // style.css (テーマのメインスタイルシート)
    wp_enqueue_style(
        'my-knowledge-theme-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get('Version') // style.cssのバージョンを自動取得
    );

    // random-background.js (背景用スクリプト)
    wp_enqueue_script(
        'my-knowledge-theme-random-background',
        get_template_directory_uri() . '/js/random-background.js',
        array(), // 依存関係なし
        '1.0',   // バージョン (必要に応じて変更)
        true     // フッターで読み込む (true)
    );

    // knowledge-filter.js (ナレッジカード絞り込みフォーム用)
    // ナレッジカードアーカイブページでのみ読み込む
    if ( is_post_type_archive('knowledge_card') ) {
        wp_enqueue_script(
            'my-knowledge-filter',
            get_template_directory_uri() . '/js/knowledge-filter.js',
            array('jquery'), // jQueryに依存
            '1.0',           // バージョン
            true             // フッターで読み込む
        );
    }
    
}
add_action( 'wp_enqueue_scripts', 'my_knowledge_theme_enqueue_scripts' );

// =========================================================================
// 3. カスタム投稿タイプ・タクソノミー登録
// =========================================================================
 function my_knowledge_theme_register_custom_types() {

    // カスタム投稿タイプ「ナレッジカード」
    $labels_knowledge_card = array(
        'name'                  => _x( 'ナレッジカード', 'Post type general name', 'my-knowledge-theme' ),
        'singular_name'         => _x( 'ナレッジカード', 'Post type singular name', 'my-knowledge-theme' ),
        'menu_name'             => _x( 'ナレッジカード', 'Admin Menu text', 'my-knowledge-theme' ),
        'name_admin_bar'        => _x( 'ナレッジカード', 'Add New on Toolbar', 'my-knowledge-theme' ),
        'add_new'               => __( '新規追加', 'my-knowledge-theme' ),
        'add_new_item'          => __( '新規ナレッジカードを追加', 'my-knowledge-theme' ),
        'new_item'              => __( '新規ナレッジカード', 'my-knowledge-theme' ),
        'edit_item'             => __( 'ナレッジカードを編集', 'my-knowledge-theme' ),
        'view_item'             => __( 'ナレッジカードを表示', 'my-knowledge-theme' ),
        'all_items'             => __( 'ナレッジカード一覧', 'my-knowledge-theme' ),
        'search_items'          => __( 'ナレッジカードを検索', 'my-knowledge-theme' ),
        'parent_item_colon'     => __( '親ナレッジカード:', 'my-knowledge-theme' ),
        'not_found'             => __( 'ナレッジカードが見つかりませんでした。', 'my-knowledge-theme' ),
        'not_found_in_trash'    => __( 'ゴミ箱にナレッジカードが見つかりませんでした。', 'my-knowledge-theme' ),
        'featured_image'        => _x( 'アイキャッチ画像', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'my-knowledge-theme' ),
        'set_featured_image'    => _x( 'アイキャッチ画像を設定', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'my-knowledge-theme' ),
        'remove_featured_image' => _x( 'アイキャッチ画像を削除', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'my-knowledge-theme' ),
        'use_featured_image'    => _x( 'アイキャッチ画像として使用', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'my-knowledge-theme' ),
        'archives'              => _x( 'ナレッジカードアーカイブ', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'my-knowledge-theme' ),
        'insert_into_item'      => _x( 'ナレッジカードに挿入', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'my-knowledge-theme' ),
        'uploaded_to_this_item' => _x( 'このナレッジカードへのアップロード', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'my-knowledge-theme' ),
        'filter_items_list'     => _x( 'ナレッジカードリストを絞り込み', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'my-knowledge-theme' ),
        'items_list_navigation' => _x( 'ナレッジカードリストナビゲーション', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'my-knowledge-theme' ),
        'items_list'            => _x( 'ナレッジカードリスト', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'my-knowledge-theme' ),
    );
    $args_knowledge_card = array(
        'labels'             => $labels_knowledge_card,
        'public'             => true,
        'has_archive'        => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'knowledge' ), // アーカイブページのURLは /knowledge/
        'capability_type'    => 'post',
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-book-alt',
        'supports'           => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions' ), // 抜粋、カスタムフィールド、リビジョンもサポート
        'show_in_rest'       => true, // ブロックエディタ対応
    );
    register_post_type( 'knowledge_card', $args_knowledge_card );

    // カスタムタクソノミー「分野」 (階層あり)
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
        'hierarchical'      => true, // 階層あり
        'labels'            => $labels_field,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'field' ), // アーカイブURLは /field/分野名/
        'show_in_rest'      => true,
    );
    register_taxonomy( 'field', array( 'knowledge_card' ), $args_field );

    // カスタムタクソノミー「分類」 (階層あり)
    $labels_classification = array(
        'name'              => _x( '分類', 'taxonomy general name', 'my-knowledge-theme' ),
        'singular_name'     => _x( '分類', 'taxonomy singular name', 'my-knowledge-theme' ),
        'search_items'      => __( '分類を検索', 'my-knowledge-theme' ),
        'all_items'         => __( 'すべての分類', 'my-knowledge-theme' ),
        'parent_item'       => __( '親分類', 'my-knowledge-theme' ),
        'parent_item_colon' => __( '親分類:', 'my-knowledge-theme' ),
        'edit_item'         => __( '分類を編集', 'my-knowledge-theme' ),
        'update_item'       => __( '分類を更新', 'my-knowledge-theme' ),
        'add_new_item'      => __( '新規分類を追加', 'my-knowledge-theme' ),
        'new_item_name'     => __( '新規分類名', 'my-knowledge-theme' ),
        'menu_name'         => __( '分類', 'my-knowledge-theme' ),
    );
    $args_classification = array(
        'hierarchical'      => true, // 階層あり
        'labels'            => $labels_classification,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'classification' ), // アーカイブURLは /classification/分類名/
        'show_in_rest'      => true,
    );
    register_taxonomy( 'classification', array( 'knowledge_card' ), $args_classification );

    // カスタムタクソノミー「知識タグ」 (階層なし)
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
        'hierarchical'          => false, // 階層なし (タグ形式)
        'labels'                => $labels_knowledge_tag,
        'show_ui'               => true,
        'show_admin_column'     => true,
        'query_var'             => true,
        'rewrite'               => array( 'slug' => 'knowledge-tag' ), // アーカイブURLは /knowledge-tag/タグ名/
        'show_in_rest'          => true,
    );
    register_taxonomy( 'knowledge_tag', array( 'knowledge_card' ), $args_knowledge_tag );
} 
add_action( 'init', 'my_knowledge_theme_register_custom_types' );
// =========================================================================
// 4. 抜粋のカスタマイズ
// =========================================================================
/**
 * 抜粋の文字数（ワード数）を変更
 */
function my_knowledge_theme_custom_excerpt_length( $length ) {
    return 45; // 45ワードに設定 (お好みで調整)
}
add_filter( 'excerpt_length', 'my_knowledge_theme_custom_excerpt_length', 999 );

/**
 * 抜粋の末尾に「続きを読む」リンクを追加
 */
function my_knowledge_theme_custom_excerpt_more( $more ) {
    global $post;
    // is_singular() で個別ページでは表示しないようにする
    if ( is_singular() ) {
        return '';
    }
    return '... <a class="read-more" href="'. esc_url( get_permalink($post->ID) ) . '">' . __( '続きを読む &raquo;', 'my-knowledge-theme' ) . '</a>';
}
add_filter( 'excerpt_more', 'my_knowledge_theme_custom_excerpt_more' );

// =========================================================================
// 5. アーカイブタイトルのカスタマイズ
// =========================================================================
/**
 * アーカイブタイトルの接頭辞（「アーカイブ:」など）を削除
 */
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

/**
 * ページタイプに応じてアーカイブタイトルをカスタマイズ
 */
function my_knowledge_theme_custom_archive_title( $title ) {
    if ( is_post_type_archive( 'knowledge_card' ) ) {
        $title = 'ナレッジカード一覧';
    } elseif ( is_tax( array('field', 'classification', 'knowledge_tag') ) ) {
        // タクソノミーアーカイブページでは「ターム名 のナレッジカード」と表示
        $title = single_term_title( '', false ) . ' のナレッジカード';
    } elseif ( is_search() ) {
        // 検索結果ページ
        $title = sprintf( esc_html__( '検索結果: %s', 'my-knowledge-theme' ), '<span>' . get_search_query() . '</span>' );
    }
    // 他のアーカイブ（カテゴリー、タグ、日付など）も必要ならここで調整
    return $title;
}
add_filter( 'get_the_archive_title', 'my_knowledge_theme_custom_archive_title' );

// =========================================================================
// 6. 検索機能のカスタマイズ
// =========================================================================
/**
 * ヘッダー検索フォームの対象を切り替える
 */
function my_knowledge_theme_search_filter( $query ) {
    // 管理画面やメインクエリでない場合は何もしない
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }

    // 検索結果ページのクエリの場合
    if ( $query->is_search() ) {
        // ラジオボタンの値を取得 (なければ 'all' とする)
        $search_target = isset( $_GET['search_target'] ) ? sanitize_text_field( $_GET['search_target'] ) : 'all';

        if ( $search_target === 'knowledge_only' ) {
            // 「ナレッジカードのみ」が選択された場合
            $query->set( 'post_type', 'knowledge_card' );
        } else {
            // 「すべて」が選択された場合 (または指定がない場合)
            // 検索対象に 'post' (投稿), 'page' (固定ページ), 'knowledge_card' (ナレッジカード) を含める
            $query->set( 'post_type', array( 'post', 'page', 'knowledge_card' ) );
        }
    }
}
add_action( 'pre_get_posts', 'my_knowledge_theme_search_filter' );

// =========================================================================
// 7. パンくずリスト生成
// =========================================================================
/**
 * パンくずリストを生成して表示する関数
 * テンプレートファイル内で <?php my_knowledge_theme_breadcrumbs(); ?> として呼び出す
 */
function my_knowledge_theme_breadcrumbs() {
    // トップページでは表示しない
    if ( is_front_page() ) {
        return;
    }

    $breadcrumbs_items = array(); // パンくず要素を格納する配列
    $separator   = '<span class="separator" aria-hidden="true"> &gt; </span>'; // 区切り文字

    // ホームへのリンク
    $breadcrumbs_items[] = array(
        'title' => esc_html__( 'ホーム', 'my-knowledge-theme' ),
        'link'  => esc_url( home_url( '/' ) ),
    );

    // --- 各ページタイプごとの処理 ---

    // ブログ記事一覧ページ (is_home)
    if ( is_home() && ! is_front_page() ) {
        $post_page_id = get_option( 'page_for_posts' );
        $breadcrumbs_items[] = array(
            'title' => esc_html( get_the_title( $post_page_id ) ),
            'link'  => '', // リンクなし
        );
    }
    // ナレッジカードのアーカイブページ
    elseif ( is_post_type_archive( 'knowledge_card' ) ) {
        $breadcrumbs_items[] = array(
            'title' => esc_html( post_type_archive_title( '', false ) ),
            'link'  => '', // リンクなし
        );
    }
    // カスタムタクソノミー (分野, 分類, 知識タグ) のアーカイブ
    elseif ( is_tax( array( 'field', 'classification', 'knowledge_tag' ) ) ) {
        $term = get_queried_object();
        if ( $term ) {
            // ナレッジカードアーカイブへのリンクを追加
            $post_type_obj = get_post_type_object( 'knowledge_card' );
            if ( $post_type_obj && $post_type_obj->has_archive ) {
                 $breadcrumbs_items[] = array(
                    'title' => esc_html( $post_type_obj->labels->archives ),
                    'link'  => esc_url( get_post_type_archive_link( 'knowledge_card' ) ),
                 );
            }

            // 親タームがあれば遡って表示
            $ancestors = get_ancestors( $term->term_id, $term->taxonomy );
            $ancestors = array_reverse( $ancestors );
            foreach ( $ancestors as $ancestor_id ) {
                $ancestor = get_term( $ancestor_id, $term->taxonomy );
                if ( $ancestor && ! is_wp_error( $ancestor ) ) {
                    $breadcrumbs_items[] = array(
                        'title' => esc_html( $ancestor->name ),
                        'link'  => esc_url( get_term_link( $ancestor ) ),
                    );
                }
            }
            // 現在のターム名 (リンクなし)
            $breadcrumbs_items[] = array(
                'title' => esc_html( $term->name ),
                'link'  => '', // リンクなし
            );
        }
    }
    // 通常のカテゴリーアーカイブ
    elseif ( is_category() ) {
        $cat = get_queried_object();
        if ( $cat ) {
            $ancestors = get_ancestors( $cat->term_id, 'category' );
            $ancestors = array_reverse( $ancestors );
            foreach ( $ancestors as $ancestor_id ) {
                $ancestor = get_category( $ancestor_id );
                if ( $ancestor && ! is_wp_error( $ancestor ) ) {
                    $breadcrumbs_items[] = array(
                        'title' => esc_html( $ancestor->name ),
                        'link'  => esc_url( get_category_link( $ancestor->term_id ) ),
                    );
                }
            }
            $breadcrumbs_items[] = array(
                'title' => esc_html( $cat->name ),
                'link'  => '', // リンクなし
            );
        }
    }
    // 通常のタグアーカイブ
    elseif ( is_tag() ) {
        $tag = get_queried_object();
        if ($tag) {
            $breadcrumbs_items[] = array(
                'title' => esc_html( $tag->name ),
                'link'  => '', // リンクなし
            );
        }
    }
    // 日付アーカイブ
    elseif ( is_date() ) {
        if ( is_year() ) {
            $breadcrumbs .= $separator . '<li>' . get_the_date( _x( 'Y年', 'yearly archives date format', 'my-knowledge-theme' ) ) . '</li>'; // 区切り文字 + li
        } elseif ( is_month() ) {
            $breadcrumbs_items[] = array(
                'title' => get_the_date( _x( 'Y年', 'yearly archives date format', 'my-knowledge-theme' ) ),
                'link'  => esc_url( get_year_link( get_the_date('Y') ) ),
            );
            $breadcrumbs_items[] = array(
                'title' => get_the_date( _x( 'F', 'monthly archives date format', 'my-knowledge-theme' ) ),
                'link'  => '',
            );
        } elseif ( is_day() ) {
            $breadcrumbs_items[] = array(
                'title' => get_the_date( _x( 'Y年', 'yearly archives date format', 'my-knowledge-theme' ) ),
                'link'  => esc_url( get_year_link( get_the_date('Y') ) ),
            );
            $breadcrumbs_items[] = array(
                'title' => get_the_date( _x( 'F', 'monthly archives date format', 'my-knowledge-theme' ) ),
                'link'  => esc_url( get_month_link( get_the_date('Y'), get_the_date('m') ) ),
            );
            $breadcrumbs_items[] = array(
                'title' => get_the_date( _x( 'j日', 'daily archives date format', 'my-knowledge-theme' ) ),
                'link'  => '',
            );
        } else {
             $breadcrumbs_items[] = array(
                'title' => get_the_archive_title(),
                'link'  => '',
             );
        }
    }
    // 投稿者アーカイブ
    elseif ( is_author() ) {
        $author = get_queried_object();
        $breadcrumbs_items[] = array(
            'title' => sprintf( esc_html__( '投稿者: %s', 'my-knowledge-theme' ), esc_html( $author->display_name ) ),
            'link'  => '',
        );
    }
    // 検索結果ページ
    elseif ( is_search() ) {
        $breadcrumbs_items[] = array(
            'title' => sprintf( esc_html__( '検索結果: %s', 'my-knowledge-theme' ), '<span>' . get_search_query() . '</span>' ),
            'link'  => '',
        );
    }
    // 固定ページ
    elseif ( is_page() ) {
        $post = get_queried_object();
        if ( $post->post_parent ) { // 親ページがあれば遡って表示
            $ancestors = get_post_ancestors( $post->ID );
            $ancestors = array_reverse( $ancestors );
            foreach ( $ancestors as $ancestor_id ) {
                $breadcrumbs_items[] = array(
                    'title' => esc_html( get_the_title( $ancestor_id ) ),
                    'link'  => esc_url( get_permalink( $ancestor_id ) ),
                );
            }
        }
        $breadcrumbs_items[] = array(
            'title' => esc_html( get_the_title() ),
            'link'  => '', // リンクなし
        );
    }
    // 個別投稿ページ (ナレッジカード, ブログ記事など)
    elseif ( is_singular() ) {
        $post = get_queried_object();
        $post_type = get_post_type( $post );

        // ナレッジカードの場合
        if ( $post_type === 'knowledge_card' ) {
            $post_type_obj = get_post_type_object( $post_type );
            if ( $post_type_obj && $post_type_obj->has_archive ) {
                $breadcrumbs_items[] = array(
                    'title' => esc_html( $post_type_obj->labels->archives ),
                    'link'  => esc_url( get_post_type_archive_link( $post_type ) ),
                );
            }
            // 主な分野の階層を表示 (最初の分野を取得)
            $fields = get_the_terms( $post->ID, 'field' );
            if ( ! empty( $fields ) && ! is_wp_error( $fields ) ) {
                $primary_field = $fields[0];
                $field_ancestors = get_ancestors( $primary_field->term_id, 'field' );
                $field_ancestors = array_reverse( $field_ancestors );
                foreach ( $field_ancestors as $ancestor_id ) {
                     $ancestor = get_term( $ancestor_id, 'field' );
                     if ( $ancestor && ! is_wp_error( $ancestor ) ) {
                         $breadcrumbs_items[] = array(
                            'title' => esc_html( $ancestor->name ),
                            'link'  => esc_url( get_term_link( $ancestor ) ),
                         );
                     }
                }
                $breadcrumbs_items[] = array(
                    'title' => esc_html( $primary_field->name ),
                    'link'  => esc_url( get_term_link( $primary_field ) ),
                );
            }
        }
        // 通常の投稿 (ブログ記事) の場合
        elseif ( $post_type === 'post' ) {
            // ブログ記事一覧ページへのリンク (設定されていれば)
            $post_page_id = get_option( 'page_for_posts' );
            if ( $post_page_id && get_post_status ( $post_page_id ) == 'publish' ) {
                 $breadcrumbs_items[] = array(
                    'title' => esc_html( get_the_title( $post_page_id ) ),
                    'link'  => esc_url( get_permalink( $post_page_id ) ),
                 );
            }
            // 主なカテゴリーの階層を表示
            $categories = get_the_category( $post->ID );
            if ( ! empty( $categories ) ) {
                $primary_category = $categories[0];
                $cat_ancestors = get_ancestors( $primary_category->term_id, 'category' );
                $cat_ancestors = array_reverse( $cat_ancestors );
                foreach ( $cat_ancestors as $ancestor_id ) {
                     $ancestor = get_category( $ancestor_id );
                     if ( $ancestor && ! is_wp_error( $ancestor ) ) {
                         $breadcrumbs_items[] = array(
                            'title' => esc_html( $ancestor->name ),
                            'link'  => esc_url( get_category_link( $ancestor->term_id ) ),
                         );
                     }
                }
                $breadcrumbs_items[] = array(
                    'title' => esc_html( $primary_category->name ),
                    'link'  => esc_url( get_category_link( $primary_category->term_id ) ),
                );
            }
        }
        // 現在の投稿タイトル (リンクなし)
        $breadcrumbs_items[] = array(
            'title' => esc_html( get_the_title() ),
            'link'  => '', // リンクなし
        );
    }
    // 404ページ
    elseif ( is_404() ) {
        $breadcrumbs_items[] = array(
            'title' => esc_html__( '404 Not Found', 'my-knowledge-theme' ),
            'link'  => '', // リンクなし
        );
    }

    // --- 配列からHTMLを生成 ---
    $breadcrumbs_html = '<nav class="breadcrumbs-container" aria-label="breadcrumb"><ol class="breadcrumbs">';
    $item_count = count( $breadcrumbs_items );

    foreach ( $breadcrumbs_items as $i => $item ) {
        $breadcrumbs_html .= '<li>';
        if ( ! empty( $item['link'] ) ) {
               $breadcrumbs_html .= '<a href="' . $item['link'] . '">' . $item['title'] . '</a>'; // ← 正しいリンク出力に修正
        } else {
            $breadcrumbs_html .= $item['title'];
        }
        // 最後の項目以外に区切り文字を追加
        if ( $i < $item_count - 1 ) {
            $breadcrumbs_html .= $separator;
        }
        $breadcrumbs_html .= '</li>';
    }

    $breadcrumbs_html .= '</ol></nav>'; // olとnavを閉じる

    echo $breadcrumbs_html; // パンくずリストを出力
}

// =========================================================================
// 6.1. ナレッジカードアーカイブの絞り込み機能
// =========================================================================
/**
 * ナレッジカードアーカイブページで、GETパラメータに基づいてタクソノミーで絞り込む
 */
function my_knowledge_theme_filter_knowledge_archive( $query ) {
    // 管理画面、メインクエリでない、ナレッジカードアーカイブでない場合は何もしない
    if ( is_admin() || ! $query->is_main_query() || ! $query->is_post_type_archive( 'knowledge_card' ) ) {
        return;
    }

    // tax_query を格納する配列を初期化
    $tax_query = array();
    // 複数のタクソノミー条件を AND で結びつける
    $tax_query['relation'] = 'AND';

    // --- 各タクソノミーのGETパラメータをチェック ---
    $taxonomies_operators = array(
        'field'          => 'IN',  // 分野は OR 条件
        'classification' => 'IN',  // 分類は OR 条件
        'knowledge_tag'  => 'AND', // タグは AND 条件
    );

    foreach ( $taxonomies_operators as $taxonomy => $operator ) {
        // GETパラメータが存在し、空でない配列であることを確認
        if ( isset( $_GET[ $taxonomy ] ) && is_array( $_GET[ $taxonomy ] ) && ! empty( $_GET[ $taxonomy ] ) ) {
            // パラメータをサニタイズ (スラッグとして安全な文字のみ許可)
            $selected_terms = array_map( 'sanitize_key', $_GET[ $taxonomy ] );

            // 空の値をフィルタリング (万が一空のvalueが送られてきた場合)
            $selected_terms = array_filter($selected_terms);

            // フィルタリング後もタームが残っている場合のみ条件を追加
            if (!empty($selected_terms)) {
                // tax_query に条件を追加
                $tax_query[] = array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'slug', // スラッグでタームを指定
                    'terms'    => $selected_terms,
                    'operator' => $operator, // 指定された演算子 (IN または AND) を使用
                );
            }
        }
    }

    // --- tax_query に条件が1つ以上追加された場合のみ、クエリにセット ---
    // $tax_query['relation'] は常に存在するので、条件配列が1つ以上あるかチェック (count > 1)
    if ( count( $tax_query ) > 1 ) {
        $query->set( 'tax_query', $tax_query );
    }
}
add_action( 'pre_get_posts', 'my_knowledge_theme_filter_knowledge_archive' );



// =========================================================================
// 8. 関連ナレッジカード表示関数 (single-knowledge_card.php で使用)
// =========================================================================
/**
 * 関連するナレッジカードを表示する関数
 *
 * @param int    $post_id 現在の投稿ID
 * @param string $taxonomy 関連付けに使うタクソノミーのスラッグ (デフォルト: 'knowledge_tag')
 * @param int    $limit    表示する最大件数 (デフォルト: 5)
 */
function display_related_knowledge_cards( $post_id, $taxonomy = 'knowledge_tag', $limit = 5 ) {
    // 現在の投稿に紐づくタームを取得
    $terms = get_the_terms( $post_id, $taxonomy );

    // タームがない場合は何もしない
    if ( empty( $terms ) || is_wp_error( $terms ) ) {
        return;
    }

    // タームIDのリストを作成
    $term_ids = wp_list_pluck( $terms, 'term_id' );

    // 関連投稿を取得するためのクエリ引数
    $args = array(
        'post_type'      => 'knowledge_card', // ナレッジカードのみ対象
        'posts_per_page' => $limit,           // 表示件数
        'post__not_in'   => array( $post_id ), // 現在の投稿は除外
        'tax_query'      => array(
            array(
                'taxonomy' => $taxonomy,
                'field'    => 'term_id',
                'terms'    => $term_ids,
                'operator' => 'IN', // いずれかのタームに合致すればOK
            ),
        ),
        'orderby'        => 'rand', // ランダム表示 (関連度順にしたい場合は変更)
    );
var_dump($args);
// または、デバッグログに出力する場合
// error_log(print_r($args, true));

$related_query = new WP_Query( $args );

    // 関連投稿が見つかった場合
    if ( $related_query->have_posts() ) :
        ?>
        <div class="related-knowledge-cards">
            <h3 class="related-title"><?php printf( esc_html__( '関連する%s', 'my-knowledge-theme' ), $related_query->query_vars['post_type'] === 'knowledge_card' ? 'ナレッジカード' : '記事' ); ?></h3>
            <ul>
                <?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                        <?php
                        // オプション: 共通するタグを表示
                        $common_terms = get_the_terms( get_the_ID(), $taxonomy );
                        if ( ! empty( $common_terms ) && ! is_wp_error( $common_terms ) ) {
                            $common_term_names = array();
                            foreach ( $common_terms as $common_term ) {
                                if ( in_array( $common_term->term_id, $term_ids ) ) {
                                    $common_term_names[] = '<a href="' . esc_url( get_term_link( $common_term ) ) . '">' . esc_html( $common_term->name ) . '</a>';
                                }
                            }
                            if ( ! empty( $common_term_names ) ) {
                                echo ' <span class="common-tags">(' . implode( ', ', $common_term_names ) . ')</span>';
                            }
                        }
                        ?>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php
        wp_reset_postdata(); // クエリをリセット
    endif; // $related_query->have_posts()
}
