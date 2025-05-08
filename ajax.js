/* ajax.js – path fix + resilient quote  */

$(function () {

  
 
  $.getJSON('news.json')
    .done(data => {
      const $list = $('#news-list').empty();
      data.news.forEach(item => {
        $('<li>')
          .append($('<a>', {
            href:   item.url,
            text:   item.title,
            target: '_blank'
          }))
          .appendTo($list);
      });
    })
    .fail(() => {
      $('#news-list').html('<li>Could not load news.</li>');
    });

  /* ----- 2. Quote of the Day (Geek-Jokes API) ----- */
  $.getJSON('https://v2.jokeapi.dev/joke/Programming?type=single')
    .done(resp => {
      $('#tech-quote').text(resp.joke);
    })
    .fail(() => {
      $('#tech-quote').text('Quote unavailable.');
    });

});
