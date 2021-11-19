// 削除確認

'use strict';

$(document).ready(function() {
  $('.delete').on('click',function() {
    if(!confirm('削除しますか？')) {
      return false;
    }else{

    }
  })
});


// アカウント削除確認

'use strict';

$(document).ready(function() {
  $('.user_delete').on('click',function() {
    if(!confirm('アカウントを削除しますか？')) {
      return false;
    }else{

    }
  })
});

// ログイン画面ネオンデザイン

'use strict';

const signs =
document.querySelector('x-sign')
  const randomIn = (min,max) =>(
    Math.floor(Math.random() * (max - min +1) +min)
  )

  const mixupInterval = el => {
    const ms = randomIn(2000,4000)
    el.style.setProperty('--interval',`${ms}ms`)
  }

  signs.forEach(el => {
    mixupInterval(el)

  el.addEventListener('webkitAnimationIteration',
  () => {
    mixupInterval(el)
  })
});

// ヘッダーネオン点滅

'use strict';

$(function () {
  setInterval(function() {
    $('.bg').fadeOut('slow', function() {
      $(this).fadeIn('slow');
    });
  }, 2000);
});