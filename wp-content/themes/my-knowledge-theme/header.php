<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); // 必須！ ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); // 必須！ ?>

<header class="site-header"> <?php // 例としてheaderタグで囲む ?>
    <h1><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
    <h2><?php bloginfo( 'description' ); ?></h2>
        <nav id="site-navigation" class="main-navigation">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'primary',      // functions.phpで登録した位置のスラッグ 'primary' を指定
                'menu_id'        => 'primary-menu', // ulタグに付与されるID (任意)
                'fallback_cb'    => false,          // メニューが未設定の場合、何も出力しない
                'depth'          => 1,              // 表示する階層（1ならサブメニューは表示しない）
            ) );
            ?>
    </nav> <?php // main-navigation の閉じタグ ?>

<?php // ↓↓↓ 検索フォームを表示 ↓↓↓ ?>
<div class="header-search">
    <?php get_search_form(); // これが searchform.php を読み込む ?>
</div>
<?php // ↑↑↑ 検索フォームここまで ↑↑↑ ?>
        
</header>

<?php // ↓↓↓ パンくずリスト表示 ↓↓↓ ?>
    <div class="breadcrumbs-container"> <?php // スタイル調整用のコンテナ ?>
        <?php
        if ( function_exists( 'my_knowledge_theme_breadcrumbs' ) ) {
            my_knowledge_theme_breadcrumbs();
        }
        ?>
    </div>
    <?php // ↑↑↑ パンくずリストここまで ↑↑↑ ?>

 <?php // メインコンテンツ部分を囲む開始タグ (任意) ?>
 <?php // 例: <div id="content" class="site-content"> ?>
