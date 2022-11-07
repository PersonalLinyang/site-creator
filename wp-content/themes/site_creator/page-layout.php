<?php
get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;

// $site_uid = $_SESSION['site_uid'];
$site_uid = '8b302ce6e5b46f7c7c47d0a072259729';

?>

<section class="simulation simulation-pc">
  <div class="simulation-inner simulation-inner-pc">
    <div class="sim-html sim-html-pc">
      <div class="sim-header">
        <div class="sim-header-inner">
          <div class="sim-header-logo">
          </div>
          <div class="sim-header-menu">
          </div>
          <div class="sim-header-controller">
          </div>
        </div>
      </div>
      <div class="sim-body">
      </div>
      <div class="sim-footer">
      </div>
    </div>
  </div>
</section>

<section class="simulation simulation-sp">
  <div class="simulation-inner simulation-inner-sp">
    <div class="sim-html sim-html-sp">
      <div class="sim-header">
        <div class="sim-header-inner">
          <div class="sim-header-logo">
          </div>
          <div class="sim-header-menu">
          </div>
          <div class="sim-header-controller">
          </div>
        </div>
      </div>
      <div class="sim-body">
      </div>
      <div class="sim-footer">
      </div>
    </div>
  </div>
</section>

<section class="setting">
</section>

<?php
get_footer();
