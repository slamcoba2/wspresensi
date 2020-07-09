
function formatDate(val, row) {
    var d = new Date(val);
    var month = d.getMonth();
    var day = d.getDate();
    month = month + 1;

    month = month + "";

    if (month.length == 1)
    {
        month = "0" + month;
    }

    day = day + "";

    if (day.length == 1)
    {
        day = "0" + day;
    }

//    return month + '-' + day + '-' + d.getFullYear();
    return day + '-' + month + '-' + d.getFullYear();

}

/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


