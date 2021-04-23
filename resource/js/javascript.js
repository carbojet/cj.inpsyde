(function($){
    console.log(cjcs.ajax)
    $('document').ready(function(){
        $('body').on('click','a.get-user-details',function(e){
            e.preventDefault();
            //postUrl = $(this).attr("href")
            postdata = {
                action:'get_user_details',
                user_id:$(this).data('id')
            }            
            //console.log(postUrl)
            $.ajax({
                url:cjcs.ajax,
                type:'post',
                data:postdata,
                success:function(responce){
                    //console.log(responce);
                    var html ='';
                    if(responce.success){
                        var userDetail = responce.data;
                        html ='<table class="table">';
                        html +='<tr><th>User Name</th><td>'+userDetail.username+'</td></tr>';
                        html +='<tr><th>Name</th><td>'+userDetail.name+'</td></tr>';
                        html +='<tr><th>Phone</th><td>'+userDetail.phone+'</td></tr>';
                        html +='<tr><th>WebSite</th><td>'+userDetail.website+'</td></tr>';
                        html +='<tr><th>Address</th><td>'+userDetail.address.suite+' '+userDetail.address.street+'</td></tr>';
                        html +='<tr><th>City</th><td>'+userDetail.address.city+'</td></tr>';
                        html +='<tr><th>Zipcode</th><td>'+userDetail.address.zipcode+'</td></tr>';
                        html +='</table>';
                    }
                    $('#userDetailModal').find('.modal-body').append(html)
                    $('#userDetailModal').modal({
                        show:'true'
                    })                    
                },
                error:function(error){
                    console.log(error)
                }
            })
        })
    })
})(jQuery);