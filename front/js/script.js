/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$(function(){
    $('button#continue').attr("disabled", true);
    $('input#url').focus();
    
    $('input#url').on('keyup',function(){
       var text = $(this).val();
       if(validateUrl(text) === false){
           $('button#continue').attr("class","notright");
           $('button#continue').attr("disabled", true);
       }
       else{
           $('button#continue').attr("class","right");
           $('button#continue').attr("disabled", false);
       } 
    });
    
    function validateUrl(url){
        var result = true;
        if(url.indexOf("ntu.edu.sg")===-1 && url.indexOf("AUS_STARS_PLANNER.planner")===-1 &&
            url.indexOf("subj_code")===-1 && url.indexOf("index_nmbr")===-1)
            result = false;
        return result;
    }
    
    
});