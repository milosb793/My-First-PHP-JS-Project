/* Script written by Adam Khoury @ DevelopPHP.com */
/* Video Tutorial: http://www.youtube.com/watch?v=EraNFJiY0Eg */
var status_forme = true ;

function _(el)
{
    return document.getElementById(el);
}

function uploadFile()
{
    var file = _("file1").files[0];
    // alert(file.name+" | "+file.size+" | "+file.type);
    var formdata = new FormData();
    formdata.append("file1", file);
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", "ajax/upload.php");
    ajax.send(formdata);
}
function progressHandler(event)
{
    _("loaded_n_total").innerHTML = "Убачено "+event.loaded+" бајтова од "+event.total;
    var percent = (event.loaded / event.total) * 100;
    _("progressBar").value = Math.round(percent);
    _("status").innerHTML = Math.round(percent)+"% убачено. Молимо сачекајте...";
}
function completeHandler(event)
{
    _("status").innerHTML = event.target.responseText;
    _("progressBar").value = 100;
}
function errorHandler(event)
{
    _("status").innerHTML = "Убацивање неуспешно!";
}
function abortHandler(event)
{
    _("status").innerHTML = "Убацивање прекинуто.";
}