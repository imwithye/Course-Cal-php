$(function(){
	$('input#submit').attr("disabled","disabled");
    document.onkeypress = stopRKey;
    $('input#url').focus();
    
    $('input#url').on('keyup',function(){
       var text = $(this).val();
       if(validateUrl(text) === false){
		   $('input#submit').attr("disabled","disabled");
           document.onkeypress = stopRKey;
       }
       else{
		   $('input#submit').removeProp("disabled");
           document.onkeypress = true;
       } 
    });
    
    $('input#submit').click(function(){
        var json = {'url': $('input#url').val()};
        var element = document.getElementById("json");
        element.value = JSON.stringify(json);
        element.form.submit();
    });
    
   function stopRKey(evt) { 
        var evt = (evt) ? evt : ((event) ? event : null); 
        var node = (evt.target) ? evt.target : ((evt.srcElement) ? evt.srcElement : null); 
        if ((evt.keyCode == 13) && (node.type=="text"))  {return false;} 
    } 
    
    function validateUrl(url){
        var result = true;
        if(url.indexOf("ntu.edu.sg")==-1 || url.indexOf("AUS_STARS_PLANNER.planner")==-1 ||
            url.indexOf("subj_code")==-1 || url.indexOf("index_nmbr")==-1)
            result = false;
        return result;
    }    
});