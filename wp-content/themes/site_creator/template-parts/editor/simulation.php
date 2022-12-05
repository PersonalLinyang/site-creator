<?php

// テンプレートパーツパラメータ変数化
$device = $args['device'];
$block = $args['block'];

?>
<div class="sim-item sim-<?php echo $block['type']; ?>" id="sim-<?php echo $block['key']; ?>-<?php echo $device; ?>">

<?php 
// 子ブロックのシミュレーション要素を構築（再帰処理）
foreach($block['blocks'] as $child_block) {
  get_template_part('template-parts/editor/simulation', null, array('device' => $device, 'block' => $child_block));
} 
?>

</div>