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
        </nav>
</header>

<main class="site-content"> <?php // メインコンテンツ部分を囲む開始タグ (任意) ?>
