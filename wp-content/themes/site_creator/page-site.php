<?php

get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

$site_status_options = array(
  'new' => __('Site Status New', $lang_domain),
);

$check_result = check_site_editor_permission();

if($check_result['result']) :
  global $wpdb;
  
  $site_uid = get_query_var('site_uid');
  $sql = 'SELECT * FROM tb_site WHERE uid="' . $site_uid . '"';
  $query = $wpdb->get_results($wpdb->prepare($sql));
  
  if(count($query)):
    $site_info = current($query);
    
    $site_status = $site_info->site_status;

//$site_status_options = get_acf_select_options('site', 'site_status');
//$site_http_options = get_acf_select_options('site', 'site_http');

//$post_status = get_field('site_status', $post->ID);
//$post_http = get_field('site_http', $post->ID);

//$common_style_list = get_field('common_style', $post->ID);
//if(!is_array($common_style_list)) {
//  $common_style_list = array();
//}

?>

<section class="single-site">
  <div class="single-site-header">
    <p class="single-site-header-status status-<?php echo $site_status; ?>"><?php echo $site_status_options[$site_status]; ?></p>
  </div>
  <h2><?php echo $site_info->site_name; ?></h2>
  <div class="single-site-info">
    <div class="single-site-info-header">
      <p class="single-site-info-header-title"><?php echo __('Site Base Info', $lang_domain); ?></p>
      <div class="single-site-info-header-btnarea">
        <p class="single-site-info-header-button" id="btn-base-edit"><?php echo __('Site Base Edit', $lang_domain); ?></p>
        <p class="single-site-info-header-button" id="btn-base-save"><?php echo __('Save', $lang_domain); ?></p>
      </div>
    </div>
    <div class="single-site-line">
      <p class="single-site-line-title"><?php echo __('Site Name', $lang_domain); ?></p>
      <p class="single-site-line-value"><?php echo $site_info->site_name; ?></p>
    </div>
<!--
    <div class="single-site-line">
      <p class="single-site-line-title"><?php echo __('Site Key', $lang_domain); ?></p>
      <p class="single-site-line-value"><?php echo get_field('site_key', $post->ID); ?></p>
    </div>
    <div class="single-site-line">
      <p class="single-site-line-title"><?php echo __('Site Host', $lang_domain); ?></p>
      <p class="single-site-line-value"><?php echo $site_http_options[$post_http]; ?><?php echo get_field('site_host', $post->ID); ?></p>
    </div>  
-->
  </div>
  <div class="single-site-info">
    <div class="single-site-info-header">
      <p class="single-site-info-header-title"><?php echo __('Site Common Style', $lang_domain); ?></p>
      <div class="single-site-info-header-btnarea">
        <p class="single-site-info-header-button">
          <a class="full-link" href="<?php echo get_site_url(); ?>/common-style/<?php echo $site_uid; ?>/">
            <?php echo __('Site Common Style Edit', $lang_domain); ?>
          </a>
        </p>
      </div>
    </div>
<!--
    <?php foreach($common_style_list as $common_style): ?>
    <div class="single-site-line">
      <p class="single-site-name"><?php echo $common_style->post_title; ?></p>
      <p class="single-site-btnedit">
        <a class="full-link" href="<?php echo get_site_url(); ?>/common-style/<?php echo $site_uid; ?>/<?php echo $common_style->post_name; ?>/">
          <?php echo __('Edit', $lang_domain); ?>
        </a>
      </p>
      <p class="single-site-btndelete"><?php echo __('Delete', $lang_domain); ?></p>
    </div>
    <?php endforeach; ?>
-->
  </div>
</section>






















<section>
  <input type="hidden" id="site-uid" value="<?php echo $site_uid; ?>"  />
  <p class="button button-download-theme">Download</p>
</section>

<?php 
  else:
    get_template_part('template-parts/error/404'); 
  endif;
else: 
  // 編集権限がない場合エラーページを表示
  get_template_part('template-parts/error/' . $check_result['error']); 
endif;

get_footer();
