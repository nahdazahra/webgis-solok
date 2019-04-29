// Code goes here

$(function(){
  $('.modal-btn').on('click',function(e){
    e.preventDefault();
    var id = this.id;
    $('#login-register-modal').load(id+'_content.html',function(response,status){
      if(status=='success')
      $('#login-register-modal').modal();
    });
  })
});