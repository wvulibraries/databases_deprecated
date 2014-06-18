$(function(){
    $('#yearMenu :checkbox').click(function(){
        var years = new Array();
        $('#yearMenu input:checked').each(function(){
            years.push( $(this).val() );
        });

        if(years.length){
            $('#issuesRoot').slideUp('fast', function(){
                $('#ajaxLoading').fadeIn('medeium', function(){
                    $('#issuesRoot fieldset').remove();
                    $.ajax({
                        url: 'listIssues.ajax.php',
                        dataType:'html',
                        type:'get',
                        data:{
                            a:'loadIssues',
                            years:years.join(',')
                        },
                        success:function(data, textStatus, XMLHttpRequest){
                            $('#ajaxLoading').hide();
                            $('#issuesRoot').html(data).slideDown('medeium');
                        }
                    });
                });
            });
        }else{
            $('#ajaxLoading').hide();
            $('#issuesRoot').slideUp('fast');
            $('#issuesRoot fieldset').remove();
            $('#issuesRoot').hide();
        }
    });
});    