// require('./bootstrap');
// window.Vue = require('vue').default;
// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
// const app = new Vue({
//     el: '#app',
// });

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

// Categories
$('#parents').select2();
$('.category_delete_modal').click(function(){
    $('.category_delete').attr('data-id', $(this).parent().attr('id'));
    $('#CategoryDeleteModal').modal();
})
$('.category_delete').click(function(){
    var id = $(this).attr('data-id');
    $.post({
        url:'/category/delete',
        data:{'id':id},
        success:function(res){
            if(res == 1){
                $('#'+id).remove();
            }
        }
    });
})

// Posts
$('#categories').select2();
$('#photo_button').click(function(){
    $('#photo').click();
})
$('.post_delete_modal').click(function(){
    $('.post_delete').attr('data-id', $(this).parent().attr('id'));
    $('#PostDeleteModal').modal();
})
$('.post_delete').click(function(){
    var id = $(this).attr('data-id');
    $.post({
        url:'/post/delete',
        data:{'id':id},
        success:function(res){
            if(res == 1){
                $('#'+id).remove();
            }
        }
    });
})

// Home
$('.post_like').click(function(){
    var this_tag = $(this);
    var id = this_tag.parent().parent().attr('id');
    if(this_tag.attr('data-key') == 0){
        var like = 1;
    }else{
        var like = 0;
    }
    $.post({
        url:'/home/like',
        data:{'id':id, 'like':like},
        success:function(res){
            if(res == 1){
                this_tag.empty().append('<i class="fas fa-thumbs-up"></i>')
            }else{
                this_tag.empty().append('<i class="far fa-thumbs-up"></i>')
            }
            this_tag.attr('data-key', res);
        }
    });
})
$('.post_dislike').click(function(){
    var this_tag = $(this);
    var id = this_tag.parent().parent().attr('id');
    if(this_tag.attr('data-key') == 0){
        var dislike = 1;
    }else{
        var dislike = 0;
    }
    $.post({
        url:'/home/dislike',
        data:{'id':id, 'dislike':dislike},
        success:function(res){
            if(res == 1){
                this_tag.empty().append('<i class="fas fa-thumbs-down"></i>')
            }else{
                this_tag.empty().append('<i class="far fa-thumbs-down"></i>')
            }
            this_tag.attr('data-key', res);
        }
    });
})

$('.post_comment').click(function(){
    $(this).next().toggle();
})

$('.send_post_comment').click(function(){
    var this_tag = $(this);
    var id = this_tag.parent().parent().parent().parent().attr('id');
    var comment = this_tag.parent().parent().find('.post_comment_input').val();
    $.post({
        url:'/home/comment',
        data:{'id':id, 'comment':comment},
        success:function(res){
            this_tag.parent().parent().find('.post_comment_input').val('');
            this_tag.parent().parent().find('.post_comments').append('<div class="col-md-2" style="padding:0">'+res+'</div>' +
                                                                     '   <div class="col-md-10" style="padding:0">'+comment+'</div>');
        }
    });
})
