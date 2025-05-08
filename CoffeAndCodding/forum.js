$(function(){
  const categories=['JavaScript','HTML','CSS','jQuery','Python','C++','Algorithms'];
  $('#topic-category').autocomplete({source:categories});
  $('#dialog-new-topic').dialog({autoOpen:false,modal:true,width:500});
  $('.new-topic').on('click',()=>$('#dialog-new-topic').dialog('open'));
  $('#new-topic-form').on('submit',function(e){
    e.preventDefault();
    $.post('forum_submit.php',$(this).serialize())
      .done(id=>{toastr.success('New topic added');window.location='topic.php?id='+id;});
  });
  $(document).on('click','.like-link',function(e){
    e.preventDefault();
    const id=$(this).data('id');
    const $count=$(this).find('.like-count');
    $.post('like_topic.php',{id}).done(r=>{if(r==='ok')$count.text(parseInt($count.text())+1);});
  });
  $(document).on('click','.delete-link',function(e){
    e.preventDefault();
    if(!confirm('Delete topic?')) return;
    const id=$(this).data('id');
    $.post('delete_topic.php',{id}).done(()=>location.reload());
  });
  $(document).on('click','.pin-link',function(e){
    e.preventDefault();
    const id=$(this).data('id');
    $.post('pin_topic.php',{id}).done(()=>location.reload());
  });
});
