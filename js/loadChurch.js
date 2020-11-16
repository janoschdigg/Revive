// Load Churches
$(document).ready(function (event) {

    $.post("phpscripts/getdata.php?type=church", function (data) {

        var container = document.getElementById("churches");
        
        var obj = JSON.parse(data);
        churchlist = obj;
        obj.forEach(element => {
            container.innerHTML += `
            <ons-list-item>
                <div class="left">
                <img class="list-item__thumbnail" src="images/churches/`+ element.logo + `">
                </div>
                <div class="center">
                <span class="list-item__title">`+ element.name + `</span><span class="list-item__subtitle">`+ element.verantwortlicher + `</span>
                </div>
            </ons-list-item>
`;
        });

    });
});