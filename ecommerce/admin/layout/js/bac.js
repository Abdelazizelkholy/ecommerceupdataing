

  $(document).ready(function(){
      
      // Dashboard
     $('.toggle-info').click(function(){
         
         $(this).toggleClass('selected').parent().next('.panel-body').fadeToggle(100);
         
         if($(this).hasClass('selected')){
             
             $(this).html(' <i class="fa fa-minus fa-lg"></i>');
         }else{
             $(this).html(' <i class="fa fa-plus fa-lg"></i>');
             
         }
         
         
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
   
   // convert password field to text field on hover.....
   
   var passwordfiled = $('.password');
   
   $('.show-pass').hover(function(){
 
       passwordfiled.attr('type','text');
            
   },function(){
       
      passwordfiled.attr('type','password'); 
   });
   
   //   confirmation delete message   
   
   $('.confirm').click(function(){
      
      return confirm("Are you sure ?");
      
   });
   
   // Category view option  
   
   $('.cat h3').click(function(){
       
       $(this).next('.full-view').fadeToggle(200);
       
   });
   
   $('.option span').click(function(){
       
       $(this).addClass('active').siblings('span').removeClass('active');
       
       if($(this).data('view') === 'full'){
           
           $('.cat .full-view').fadeIn(200);
           
       }else{
           
           $('.cat .full-view').fadeOut(200);
           
       }
       
       
   });
   
        // Show delete button on Chlid cat
        
        $('.chlid-link').hover(function(){
            
            $(this).find('.show-delete').fadeIn(400);
            
        },function(){
            
            $(this).find('.show-delete').fadeOut(400);
            
        });
   
   
   
}); 