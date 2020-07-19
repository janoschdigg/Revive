// Load Animation
$(document).ready(function (event) {
    $('#loading').show();
    setTimeout(function () {
        $('#loading').fadeOut();
    }, 100);
});


// Load Activities
$(document).ready(function (event) {

    $.post("phpscripts/getdata.php?type=activity", function (data) {

        var container = document.getElementById("acitivities");

        var obj = JSON.parse(data);


        obj.forEach(element => {
            container.innerHTML += `
<ons-card onclick='detail(`+ element.id + `)' id='activity' class='act'>
    <div class='calendarDate'>	
    <em>Samstag</em>
    <strong>Dezember</strong>
    <span>21</span>
    </div>
    <div class='actright title'>`+ element.title + `</div>
    <div class='actright content'>`+ element.body + `</div>
</ons-card>
`;
        });

    });
});

// Load Churches
$(document).ready(function (event) {

    $.post("phpscripts/getdata.php?type=church", function (data) {

        var container = document.getElementById("churches");

        var obj = JSON.parse(data);

        obj.forEach(element => {
            container.innerHTML += `
            <ons-card class='church'>
            <img src='images/churches/`+ element.logo + `' class='churchlogo'>
            <div class='title churchright'>`+ element.name + `</div>
            <div class='content churchright'>`+ element.verantwortlicher + `</div>
            </ons-card>
`;
        });

    });
});






