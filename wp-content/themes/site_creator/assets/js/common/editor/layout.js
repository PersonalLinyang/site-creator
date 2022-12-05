// レイアウトエリアを初期化
const initFormLayout = function(obj_layout) {
  var sim = obj_layout.find('.form-layout-sim');
  var target = obj_layout.closest('.form-block').data('target');
  
  // ブロックリンクのインデックス更新
  var updateFormLayoutSimItemIndex = function(items) {
    items.each(function(){
      var index = items.index($(this));
      $(this).find('.form-layout-sim-item-index').prop('name', target + '__blocks__' + index);
    });
  }
  
  // 並び方変更
  obj_layout.find('.form-layout-seltype').on('change', function(){
    var type = $(this).val();
    if(type == 'r') {
      // 横並び
      sim.addClass('row-layout');
      $('#sim-' + target + '-pc').css('display', 'flex');
      $('#sim-' + target + '-sp').css('display', 'flex');
    } else {
      // 縦並び
      sim.removeClass('row-layout');
      $('#sim-' + target + '-pc').css('display', 'block');
      $('#sim-' + target + '-sp').css('display', 'block');
    }
  });
  
  // ブロック追加ボタンをクリック
  obj_layout.find('.form-layout-btnadd').on('click', function(){
    var button = $(this);
    if(!button.hasClass('working')) {
      button.addClass('working');
      
      // 現在のブロック数を取得
      var block_index = parseInt($('.setting').data('index'));
      // ブロックがない場合のダミー要素を取得
      var dummy = sim.find('.form-layout-sim-dummy');
      
      // ブロックがない場合ダミー表示を非表示する
      if(sim.find('.form-layout-sim-item').length == 0) {
        sim.find('.form-layout-sim-dummy').hide();
      }
      
      // ブロックリストにブロックリンクを追加
      var form_layout_sim_item = `
        <div class="form-layout-sim-item form-block-slide" data-target="block` + block_index + `">
          <p class="form-layout-sim-item-btnsort"></p>
          <p class="form-block-slide-handler form-layout-sim-item-btnedit" data-target="block` + block_index + `"></p>
          <p class="form-layout-sim-item-btndelete"></p>
          <p class="form-layout-sim-item-text" title="` + translations.block_without_name + `">` + translations.block_without_name + `</p>
          <input class="form-layout-sim-item-index" type="hidden" name="` + target + `__blocks__" value="block` + block_index + `" />
        </div>
      `;
      dummy.before(form_layout_sim_item);
      
      // ブロックを追加
      addFormBlock('block', block_index, target);
      
      // 新しく追加したブロックリンクを取得
      var sim_item = sim.find('.form-layout-sim-item[data-target="block' + block_index + '"]');
      
      // ブロック削除ボタンを有効化
      sim_item.find('.form-layout-sim-item-btndelete').on('click', function(){
        sim_item.remove();
        $('.form-block[data-target="block' + block_index + '"]').remove();
        updateFormLayoutSimItemIndex(sim.find('.form-layout-sim-item'));
      });
      
      // ブロック編集ボタンを有効化
      initFormBlockSlidehandler(sim_item.find('.form-layout-sim-item-btnedit'));
      
      // ブロックリンクのインデックス更新
      updateFormLayoutSimItemIndex(sim.find('.form-layout-sim-item'));
      
      // 現在のブロック数を更新
      $('.setting').data('index', (block_index + 1));
      
      
      $('#sim-' + target + '-pc').append('<div class="sim-item sim-block" id="sim-block' + block_index + '-pc" style="width: calc(100% - 20px); min-height: 200px; margin: 10px;"></div>');
      $('#sim-' + target + '-sp').append('<div class="sim-item sim-block" id="sim-block' + block_index + '-sp" style="width: calc(100% - 20px); min-height: 200px; margin: 10px;"></div>');
      
      
      // ボタンをクリックできるようにする
      button.removeClass('working');
    }
  });
  
  // ブロックリンクの並び替え機能を有効化
  sim.sortable({
    handle: '.form-layout-sim-item-btnsort',
    stop: function(e, ui){
      // ブロックリンクのインデックス更新
      updateFormLayoutSimItemIndex(sim.find('.form-layout-sim-item'));
    },
  });
  
  // ブロックリンクのインデックス初期化
  updateFormLayoutSimItemIndex(sim.find('.form-layout-sim-item'));
}