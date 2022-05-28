function checkSelection() {
    if ($('input[type=checkbox]:checked').length > 0) {
        $('button[name=export]').show()
    } else {
        $('button[name=export]').hide()
    }
}

function download() 
{
    $('.alert-primary').show();
    setInterval(function() {
        $('.alert-primary').hide();
    }, 2 * 1000)
    var ele = document.createElement('a');
    if (isAll) {
        ele.setAttribute('href', "/index.php?r=site/export&all="+isAll); //设置下载文件的url地址
    } else {
        var ids = ""
        $('input[type=checkbox]:checked').each(function(idx, item) {
            ids += $(item).val() + ","
        })
        ele.setAttribute('href', "/index.php?r=site/export&all=0&id="+ids); //设置下载文件的url地址

    }
    ele.setAttribute('download' , 'download');//用于设置下载文件的文件名
    ele.click();
}

$(document).ready(function() {
    $(":checkbox").change(function() {
        checkSelection()
    })
})

$('#all-check').click(function() {
    $('.i-checks').prop('checked', 'checked')
    $('#select-msg').show()
    checkSelection()
})

$('#reverse-check').click(function() {
    $('.i-checks').each(function(i, item) {
        $(item).prop('checked', !$(item).prop('checked'))
    })
    $('#select-msg').hide()
    checkSelection()
})

var isAll = 0
function selectAll() {
    $('.i-checks').prop('checked', 'checked')
    $('#select-msg').hide()
    $('#select-msg2').show()
    isAll = 1
}

function cleanAll() {
    isAll = 0
    $('.i-checks').prop('checked', false)
}