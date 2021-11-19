// ブックマーク追加確認

'use strict';

$(document).ready(function() {
  $('.btn_bookmark').on('click',function() {
    if(!confirm('ブックマークに追加しました！')) {
      return false;
    }else{

    }
  })
});