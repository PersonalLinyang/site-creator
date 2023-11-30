<?php

// SCSSコンパイル

require_once 'inc/scssphp-master/scss.inc.php';

use ScssPhp\ScssPhp\Compiler;

$compiler = new Compiler();

$compiler->setImportPaths(get_template_directory() . '/src/scss/');

$css = $compiler->compileString('@import "style.scss";')->getCss();
?>

<?php echo $css;?>