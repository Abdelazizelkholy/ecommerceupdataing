

  $(document).ready(function(){
       
       // login/signup
       // switch beetween login & signup
       
       $('.login-page h1 span').click(function(){
          
           $(this).addClass('selected').siblings().removeClass('selected');
           $('.login-page form').hide();
           $('.'+$(this).data('class')).fadeIn(100);
       });
        

      //  select box
      
    $("select").selectBoxIt({
        
        autoWidth:false
    });    
      
   
   $('input').each(function(){
       
       
       if($(this).attr('required') === 'required'){
           
          $(this).after('<span class="asterisk" >*</span>'); 
       }
       

   });
   
   
   
   //   confirmation delete message   
   
   $('.confirm').click(function(){
      
      return confirm("Are you sure ?");
      
   });
   
   $('.live').keyup(function(){
       
       $($(this).data('class')).text($(this).val());
       
   });
   
   
   
 
}); 