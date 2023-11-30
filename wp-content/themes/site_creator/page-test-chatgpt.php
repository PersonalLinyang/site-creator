<?php
get_header();

$lang_code = function_exists('qtranxf_getLanguage') ? qtranxf_getLanguage() : 'ja';
$lang_domain = 'site-creator-' . $lang_code;
?>

<style>
.test-result {
  overflow: auto;
  max-height: 350px;
  padding: 0 20px;
}
.test-item {
  border-top: 1px solid #000;
}
</style>

<h2>TEST ChatGPT API</h2>

<div class="test-inputarea">
  <input class="test-input" type="text" />
  <p class="test-button">send</p>
</div>

<div class="test-result">
</div>


<script>
$(document).ready(function() {
    var apiKey = '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';
    var apiUrl = 'https://api.openai.com/v1/chat/completions';
    var contextMessages = [];
    
    $('.test-button').click(function(){
      if($('.test-input').val()){
        
        $('.test-result').append('<p class="test-item">' + $('.test-input').val() + '</p>');
        
        contextMessages.push({ role: 'user', content: $('.test-input').val() });
        
        var data = {
          model: 'gpt-3.5-turbo',
          messages: contextMessages
        }
        
        $.ajax({
            type: 'POST',
            url: apiUrl,
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + apiKey
            },
            data: JSON.stringify(data),
            success: function(response) {
                // 处理API响应
                $('.test-result').append('<p class="test-item">' + JSON.stringify(response, null, 2) + '</p>');
                
                var assistantReply = response.choices[0].message.content;
                contextMessages.push({ role: 'assistant', content: assistantReply });
            },
            error: function(xhr, textStatus, errorThrown) {
                // 处理错误
                $('#response').text('Error sending request.');
            }
        });
        
        $('.test-input').val('');
      }
    });

});
</script>

<?php
get_footer();

// GPT送信例
// 我需要一个配色，这个配色用于一个主页，包括四种颜色，希望你可以用JSON给我回答，这四个颜色分别是用于页面整体body的背景色，JSON中命名为background，第二种是页面上各个模块div或section使用的背景颜色，JSON中命名为block，第三种为页面中标题h1到h5的文字颜色，JSON中命名为hcolor，第四种为页面中普通文字p或span之类使用的文字颜色，JSON中命名为tcolor，前两种背景颜色要求和谐，不要太过突兀，后两种文字颜色也要和谐，但要和前两种背景颜色明显区分，是页面有很好的可读性，页面整体的氛围有几个关键词，是神秘，奢华，中国风，你的回答不要有你的话，也不要有问题，请只给我JSON