<?php

require_once get_template_directory() . '/inc/custom-functions/check_site_editor_permission.inc.php';

get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

$target_uid = get_query_var('target_uid');
$check_result = check_site_editor_permission();

$temp_args = array(
  'base_flag' => true,
  'block_id' => '',
  'block_type' => '',
  'block_parent' => '',
);
if($check_result['result']) :
  $target = $check_result['target'];
  if($target->post_type == 'site') {
    $temp_args['block_type'] = 'body';
  } else {
    $temp_args['block_id'] = $target->ID;
    $temp_args['block_type'] = 'body';
  }
?>

<section class="sim sim-pc">
  <div class="sim-inner sim-inner-pc">
    <div class="sim-item sim-html sim-html-pc" id="sim-body-pc">
    <div class="sim-body">
      <div class="sim-header" id="sim-header-pc" style="background: #f00; width: 100%; height: 50px; margin-top: 5px;">
      </div>
      <div class="sim-main" id="sim-main-pc" style="background: #fff; min-height: 2500px;">
        <p>START</p>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <p>END</p>
      </div>
      <div class="sim-footer" id="sim-footer-pc" style="background: #f00; height: 50px;">
      </div>
      </div>
    </div>
  </div>
</section>

<section class="sim sim-sp">
  <div class="sim-inner sim-inner-sp">
    <div class="sim-html sim-html-sp" id="sim-body-sp">
    <div class="sim-body">
      <div class="sim-header" id="sim-header-sp" style="background: #f00; width: 100%; height: 50px; ">
      </div>
      <div class="sim-main" id="sim-main-sp" style="background: #fff; min-height: 2500px;">
        <p>START</p>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <div class="sim-content" id="sim-content0">
          <h1><?php echo __('Site H1 Simulation Content', $lang_domain); ?></h1>
          <h2><?php echo __('Site H2 Simulation Content', $lang_domain); ?></h2>
          <h3><?php echo __('Site H3 Simulation Content', $lang_domain); ?></h3>
          <h4><?php echo __('Site H4 Simulation Content', $lang_domain); ?></h4>
          <h5><?php echo __('Site H5 Simulation Content', $lang_domain); ?></h5>
          <p><?php echo __('Site P Simulation Content', $lang_domain); ?></p>
          <img href="" />
          <a><?php echo __('Site A Simulation Content', $lang_domain); ?></a>
          <ul>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
            <li><?php echo __('Site Li Simulation Content', $lang_domain); ?></li>
          </ul>
        </div>
        <p>END</p>
      </div>
      <div class="sim-footer" id="sim-footer-sp" style="background: #f00; height: 50px;">
      </div>
      </div>
    </div>
  </div>
</section>

<section class="setting">
  <h2 class="setting-title"><?php echo __('Site Common Style Edit', $lang_domain); ?></h2>
  
  <form class="form form-style" id="common-style-form">
    <input type="hidden" name="target_id" value="<?php echo $target->ID; ?>" />
    
    <div class="form-body">
      <?php get_template_part('template-parts/editor/form-block', null, $temp_args); ?>
    </div>
  </form>
</section>

<?php else: ?>
  <?php get_template_part('template-parts/error/' . $check_result['error']); ?>
<?php 
endif;
get_footer();
