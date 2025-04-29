<?php
/**
 * The sidebar containing the knowledge filter widgets.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package My_Knowledge_Theme
 */

// ウィジェットエリア 'knowledge-filter-area' がアクティブかチェック
// functions.php で register_sidebar した ID を指定してください
if ( ! is_active_sidebar( 'knowledge-filter-area' ) ) {
	return; // ウィジェットがなければ何も表示しない
}
?>

<aside id="secondary" class="knowledge-filter-sidebar widget-area" role="complementary">
	<?php dynamic_sidebar( 'knowledge-filter-area' ); // ウィジェットエリアの内容を表示 ?>
</aside><!-- #secondary -->
