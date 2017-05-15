jQuery(function($){
    $('#button').click(function(){
        var data = {
            'action': 'load_more',
            'query': posts,
            'page' : current_page
        };
        $.ajax({
            url:window.wp_data.ajax_url, // обработчик
            data:data, // данные
            type:'POST', // тип запроса
            success:function(data){
                if( data ) {
                    $('#gallery-content').append(data); // вставляем новые посты
                    current_page++; // увеличиваем номер страницы на единицу
                    if (current_page == max_pages) $('.btn.more-content').remove(); // если последняя страница, удаляем кнопку
                } else {
                    $('.btn.more-content').remove(); // если мы дошли до последней страницы постов, скроем кнопку
                }
            }
        });
    });
});
