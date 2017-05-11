jQuery(function($){
    $('#button').click(function(){
        $(this).text('Загружаю...'); // изменяем текст кнопки, вы также можете добавить прелоадер
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
                    $('#button').text('Загрузить ещё').before(data); // вставляем новые посты
                    current_page++; // увеличиваем номер страницы на единицу
                    if (current_page == max_pages) $('#button').remove(); // если последняя страница, удаляем кнопку
                } else {
                    $('#button').remove(); // если мы дошли до последней страницы постов, скроем кнопку
                }
            }
        });
    });
});
