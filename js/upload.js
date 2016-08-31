/* Script written by Adam Khoury @ DevelopPHP.com */
/* Video Tutorial: http://www.youtube.com/watch?v=EraNFJiY0Eg */
var status_forme = true ;

function _(el)
{
    return document.getElementById(el);
}

function uploadFile(materijal_id,lab_vezba_id)
{
    alert("мат: " + materijal_id + "лаб.: "+lab_vezba_id);

    var file = _("file1").files[0];
    // alert(file.name+" | "+file.size+" | "+file.type);
    var formdata = new FormData();
    formdata.append("file1", file);
    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);

    ajax.onreadystatechange = function ()
    {
        if (this.readyState == 4 && this.status == 200)
        {
            alert(this.responseText);

            // use response in here.
        }
    };

    if(parseInt(materijal_id)!=0)
    {
        ajax.open("POST", "ajax/upload.php?zid=1&materijal_id="+materijal_id+"");
    }
    if(parseInt(lab_vezba_id)!=0)
    {
        ajax.open("POST", "ajax/upload.php?zid=1&lab_vezba_id="+lab_vezba_id+"");
    }

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

