<?php

/*
 * Wordpressコア機能関連functions
 */
get_template_part('functions/core');


/*
 * リダイレクト関連functions
 */
get_template_part('functions/rewrite_rules');


/*
 * カスタム投稿タイプ関連functions
 */
get_template_part('functions/custom_type');


/*
 * ショットコード関連functions
 */
get_template_part('functions/shortcode');


/*
 * CSS関連functions
 */
get_template_part('functions/style');


/*
 * Javascript関連functions
 */
get_template_part('functions/javascript');


/*
 * Ajax関連functions
 */
// アカウント関連functions
get_template_part('functions/ajax/account');
// サイト作成関連functions
get_template_part('functions/ajax/create_site');
// テーマ出力関連functions
get_template_part('functions/ajax/zip_theme');
// エディター関連functions
get_template_part('functions/ajax/editor');
