var engineCSRF=null;
$(function(){
    engineCSRF=$('#content :hidden[name=engineCSRFCheck]').val();
    if(location.hash) switch(location.hash){
        case '#browser':
            issueBrowser('open');
            break;
        case '#new':
            newIssue('open');
            break;
        case '#snippets':
            snippetEditor('open');
            break;
    }
});

var userAlertRunningDuration_move = 750;
var userAlertRunningDuration_show = 3000;
var userAlertRunning              = false;
var userAlertQue                  = new Array();
function userAlert(msg){
    userAlertQue.push(msg);
    if(!userAlertRunning) userAlertRun();
    return userAlertQue.length;
}
function userAlertRun(){
    if(!userAlertQue.length){
        userAlertRunning=false;
        return false;
    }
    userAlertRunning=true;
    var msg = userAlertQue.shift();
    var userAlert = $('#userAlert');
    var height= userAlert.html(msg).innerHeight();
    userAlert.css('top', -1*height).animate({top:'0'}, userAlertRunningDuration_move, null, function(){
        userAlert.delay(userAlertRunningDuration_show).animate({top:'-'+height}, userAlertRunningDuration_move, null, function(){
            userAlertRun();
        });
    });
    return true;
}    

function issueRowHighlight(id){
    var liRow = $('#issueRow-'+id);
    if(liRow.length){
        var pos = liRow.position();
        window.scrollTo(pos.left,pos.top);
        liRow.css('background-color', 'yellow');
        setTimeout("issueRowHighlight_clear("+id+")",4000);
    }
}
function issueRowHighlight_clear(id){
    $('#issueRow-'+id).css('background-color', '');
}
//=============================================================================


function issueBrowser(direction, callbackFn){
    if(direction=="open"){
        newIssue('close');
        snippetEditor('close');
        $('#issueBrowser').slideDown(null, function(){
            if(typeof(callbackFn) == "function") callbackFn();
        });
    }else{
        $('#issueBrowser').slideUp(null, function(){
            $('#browse-issueList').html('');
        });
    }
}

function loadYear(year, callbackFn){
     $.ajax({
         url:'issueGrid.ajax.php',
         type:'get',
         dataType:'html',
         data:{
             'year': year
         },
         beforeSend:function(XMLHttpRequest, settings){
             $('#yearMenuNode-'+year+' > .yearMenuWait').show();
             $('#yearMenuNode-'+year+' > .yearMenuLink').hide();
         },
         success:function(data, textStatus, XMLHttpRequest){
             $('#yearMenuNode-'+year+' > .yearMenuWait').hide();
             $('#yearMenuNode-'+year+' > .yearMenuLink').show();
             $('#browse-issueList').html(data);
             if(typeof(callbackFn) == "function") callbackFn();
         }
     });
 }
function deleteIssue(id){
    if(prompt("You are about to delete this issue forever.\nThis cannot be undone!\n\nPlease type 'delete' bellow to continue.").toLowerCase() == "delete"){
        $.ajax({
          url: 'actions.ajax.php?action=delete',
          type:'post',
          dataType: 'json',
          data:{
              'id':id,
              'engineCSRFCheck': engineCSRF
          },
          success: function(data){
              if(data.success == 1){
                  $('#issueRow-'+data.id).slideUp('slow').remove();
                  $('#issueDetailsRow-'+data.id).slideUp('slow').remove();
                  $('#issueHrRow-'+data.id).slideUp('slow').remove();
                  userAlert(data.userAlert);
              }
              else userAlert(data.userAlert);
          }
        });
    }else{
        userAlert('<p class="successMessage">Delete canceled</p>');
    }
}
function editIssue(id){
    if($('#issueDetailsRow-'+id+' .issueDetails').css('display') == "block"){
        viewIssue(id)
    }

    if( $('#issueDetailsRow-'+id+' .issueEdit').html() == "" ){
        $.ajax({
            url:'actions.ajax.php?action=edit-form',
            type:'post',
            dataType:'html',
            data:{
                'id': id,
                'engineCSRFCheck': engineCSRF
            },
            beforeSend:function(XMLHttpRequest, settings){
                $('#issueRow-'+id+' .editWait').hide();
                $('#issueRow-'+id+' .editWait').show();
            },
            success:function(data, textStatus, XMLHttpRequest){
                $('#issueRow-'+id+' .editWait').hide();
                $('#issueRow-'+id+' .editLink').show();
                $('#issueDetailsRow-'+id+' .issueEdit').html(data).slideToggle('medium');;
            }
        });
    }else{
        $('#issueDetailsRow-'+id+' .issueEdit').slideToggle('medium');
    }
}
function editIssueAJAX(formObj, id){
    $.ajax({
        url:'actions.ajax.php?action=edit',
        type:'post',
        dataType:'json',
        data:{
            'id': id,
            'engineCSRFCheck': engineCSRF,
            'issueDate-m': $('select[name="issueDate_month"]', formObj).val(),
            'issueDate-d': $('select[name="issueDate_day"]', formObj).val(),
            'issueDate-y': $('select[name="issueDate_year"]', formObj).val(),
            'issueNumber': $('input[name="issueNumber"]', formObj).val()
        },
        beforeSend:function(XMLHttpRequest, settings){
            $('input[name="updateButton"]', formObj).attr('disabled', 'disabled').val('Please wait...').blur();
        },
        success:function(data, textStatus, XMLHttpRequest){
            // Unlock the form
            $('input[name="updateButton"]', formObj).removeAttr('disabled').val('Update issue');
            // Show a userAlert
            userAlert(data.userAlert);
            // Process the result
            if(data.success){
                // Is there a yearMenu item for this new issueYear?
                addYearNode2yearMenu(data.issueYear);
                // Update the issue's row
                $('#issueRow-'+data.issueID+' .issueDate').html(data.issueDate);
                $('#issueRow-'+data.issueID+' .issueNumber').html(data.issueNumber);
                // Close the edit window
                editIssue(data.issueID);
            }
        }
    });
    return false;
}

function viewIssue(id){
    if($('#issueDetailsRow-'+id+' .issueEdit').css('display') == "block"){
        editIssue(id)
    }

    if( $('#issueDetailsRow-'+id+' .issueDetails').html() == "" ){
        $.ajax({
            url:'actions.ajax.php?action=info',
            type:'post',
            dataType:'html',
            data:{
                'id': id,
                'engineCSRFCheck': engineCSRF
            },
            beforeSend:function(XMLHttpRequest, settings){
                $('#issueRow-'+id+' .infoLink').hide();
                $('#issueRow-'+id+' .infoWait').show();
            },
            success:function(data, textStatus, XMLHttpRequest){
                $('#issueRow-'+id+' .infoWait').hide();
                $('#issueRow-'+id+' .infoLink').show();
                $('#issueDetailsRow-'+id+' .issueDetails').html(data).slideToggle('medium');;
            }
        });
    }else{
        $('#issueDetailsRow-'+id+' .issueDetails').slideToggle('medium');
    }
}



function newIssue(direction){
    if(direction=="open"){
        issueBrowser('close');
        snippetEditor('close');
        $('#newIssue').slideDown();
    }else{
        $('#newIssue').slideUp();
    }
}
function newIssueAJAX(){
    $('#newIssueForm :submit').attr('disabled','disabled').val("Working...");
    $('#newIssueWait').show();
}
function newIssueAJAX_finish(){
    $('#newIssueForm :submit').removeAttr('disabled').val("Create issue");
    $('#newIssueWait').hide();

    var iFrame = $('#uploadAJAX').contents();
    if($('ajaxUpload errorCount', iFrame).text()=='0' && $('ajaxUpload db success', iFrame).text()=='1'){
        addYearNode2yearMenu($('ajaxUpload issue issueYear', iFrame).text());
        userAlert($('userAlert', iFrame).html());
        issueBrowser('open', function(){
            loadYear($('ajaxUpload issue issueYear', iFrame).text(), function(){
                issueRowHighlight($('ajaxUpload db id', iFrame).text());
            });
        });
        document.getElementById("newIssueForm").reset();
    }else{
        userAlert($('userAlert', iFrame).html());
    }
}


function snippetEditor(direction){
    if(direction=="open"){
        issueBrowser('close');
        newIssue('close');
        $('#snippetEditor').slideDown();
    }else{
        $('#snippetEditor').slideUp();
    }
}

var currentSnippetEdit=null
function editSnippet(id){
    if(currentSnippetEdit != id){
        currentSnippetEdit=id;
        $('#snippetEditLink-'+id).hide();
        $('#snippetEditWait-'+id).show();
        $('#snippetEditorArea').slideUp('medium', function(){
            $.ajax({
                url:'snippetEditor.ajax.php?mode=form',
                type:'post',
                dataType:'html',
                data:{
                    'engineCSRFCheck': engineCSRF,
                    'id': id
                },
                success:function(data){
                    $('#snippetEditorArea').html(data).slideDown('medium', function(){
                        $('#snippetEditLink-'+id).show();
                        $('#snippetEditWait-'+id).hide();
                    });
                }
            });
        }).html('');
    }
}

function updateSnippet(){
    $.ajax({
        url:'snippetEditor.ajax.php?mode=update',
        type:'post',
        dataType:'json',
        data:{
            'engineCSRFCheck': engineCSRF,
            'id': $('#snippetEditorArea #ID_insert').val(),
            'name': $('#snippetEditorArea #name_insert').val(),
            'systems': $('#snippetEditorArea select[name=systems_insert]').val(),
            'value': $('#tinymce p', $('#value_insert_ifr').contents()).html()
        },
        beforeSend:function(){
            $('#snippetEditorArea form :submit[name=snippets_submit]').val("Saving Changes...").attr('disabled', 'disabled');
            $('#snippetsWait').show();
        },
        success:function(data){
            if(data.success){
                $('#snippetsSubmit').val("Save changes").removeAttr('disabled');
                $('#snippetEditorArea').slideUp('slow').html('');
                $('#name_'+data.id).val(data.snippet.name);
                $.globalEval("var currentSnippetEdit=null;");
            }
            userAlert(data.userAlert);
        }
    });
}

function addYearNode2yearMenu(year){
    // Make sure year is an int
    year = parseInt(year);
    yearStr = year.toString();

    if(!$('#yearMenuNode-'+year.toString()).length){
        // Crud, we need to make it!
        var LiNode = '<li class="yearMenuNode" id="yearMenuNode-'+yearStr+'"><a href="javascript:loadYear('+yearStr+');" class="yearMenuLink">'+yearStr+'</a><img src="../images/ajaxLoader.gif" alt="Loading..." class="yearMenuWait" style="display:none;"></li>';
        if(parseInt($('.yearMenuNode:first a').text()) > year){
            $('.yearMenuNode:first').before(LiNode);
            return true;
        }else if(parseInt($('.yearMenuNode:last a').text()) < year){
            $('.yearMenuNode:last').after(LiNode);
            return true;
        }else{
            $('.yearMenuNode').each(function(){
                if(parseInt($('a', this).text()) > year) $(this).before(LiNode);
            });
            return true;
        }
    }else{
        return false;
    }
}
