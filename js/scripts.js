// Load Animation
$(document).ready(function (event) {
    $('#loading').show();
    setTimeout(function () {
        $('#loading').fadeOut();
    }, 1);
});


var activitylist = null;
var churchlist = null;

// Load Activities
$(document).ready(function (event) {
    reloadactivities();
   
});
function reloadactivities()
{
    $.post("phpscripts/getdata.php?type=activity", function (data) {

        var obj = JSON.parse(data);
        activitylist = obj;
        printActivities(0);
    
        });
}
function printActivities(category)
{
    var container = document.getElementById("acitivities");

    container.innerHTML = "";

    activitylist.forEach(element => {
        var days = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
        var date = new Date(element.date);
        var dayName = days[date.getDay()];
        var backgroundclass = '';
        if(element.fcategoryID == 1)
        {
            backgroundclass = 'red';
        }
        else if(element.fcategoryID == 2){
            backgroundclass = 'yellow';
        }
        else{
            backgroundclass = 'blue';
        }
        if(element.fcategoryID == category || category == 0)
        {
            container.innerHTML += `
            <ons-card onclick='detail(`+ element.id + `)' id='activity' class='act `+ backgroundclass + `'>
                <div class='calendarDate'>	
                <em>`+ dayName + `</em>
                <strong>`+ date.toLocaleString('de-ch', { month: 'long' }) + `</strong>
                <span>`+ date.getDate() + `</span>
                </div>
                <div class='actright title'><b>`+ element.title + `</b></div>
                <div class='minimizeContent actright content '>`+ element.body + `</div>
            </ons-card>
            `;
        }
        
    });
}

// Load Churches
$(document).ready(function (event) {

    $.post("phpscripts/getdata.php?type=church", function (data) {

        var container = document.getElementById("churches");
        
        var obj = JSON.parse(data);
        churchlist = obj;
        obj.forEach(element => {
            container.innerHTML += `
            <ons-card class='church'>
            <img src='images/churches/`+ element.logo + `' class='churchlogo'>
            <div class='title churchright'>`+ element.name + `</div>
            <ons-icon style="font-size: 24px; margin-top: -20px; margin-right: 0px; color: darkgray; float: right;" icon="md-email"></ons-icon>
            <div class='content churchright'>`+ element.verantwortlicher + `</div>
            </ons-card>
`;
        });

    });
});

function sendRegister(id)
{
    name = document.getElementById('name').value;
    phone = document.getElementById('phone').value;
    document.getElementById('name').value = "";
    document.getElementById('phone').value = "";

    $.post("phpscripts/postdata.php?type=registration&id="+id+"&name="+name+"&phone="+phone, function (data) {});

    alert("Du hast dich erfolgreich angemeldet!");
}

function register(id, name) {
    console.log("Register" + id);
    var container = document.getElementById("detailsContainer");
    container.innerHTML = `
    <ons-card>
    <div class='title'>Anmeldung `+ name + `</div>
    <ons-list class="content">
        <ons-list-header>Angaben zu dir</ons-list-header>
        <ons-list-item class="input-items">
        <label class="center">
        <ons-input id="name" float maxlength="20" placeholder="Name / Vorname"></ons-input>
        </label>
        </ons-list-item>
        <ons-list-item class="input-items">
            <label class="center">
            <ons-input id="phone" float maxlength="20" placeholder="Telefonnummer"></ons-input>
            </label>
        </ons-list-item>
        <div class="btn" onclick="sendRegister(`+ id +`)">Anmelden</div>

    </ons-list>
    </ons-card>
    `;
}

//Load Detail Data from Activity
function getDetailData(id) {
    $.post("phpscripts/getdata.php?type=detail&id=" + id, function (data) {

        var container = document.getElementById("detailsContainer");

        var obj = JSON.parse(data);

        obj.forEach(element => {

            var days = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
            var date = new Date(element.date);
            var dayName = days[date.getDay()];

            var progressvalue = (element.booked / element.participants) * 100;
       
            var user = $.post("phpscripts/getdata.php?type=user&id=" + element.fuserid, function (dataUser) {
                return JSON.parse(data);
            }, 'json');

            button ="";
            if(progressvalue < 100)
            {
                button = `<div class="btn" onclick="register(`+ element.id + `, '` + element.title + `')">Anmelden</div>`;
            }

            container.innerHTML += `<ons-card>

            <div class="title"><b>`+ element.title + `</b></div>
            <div class="title" style="font-size: 18px; margin-bottom: 5px;"><ons-icon icon="ion-md-calendar">  ` + dayName + " " + date.getDate()+". " + date.toLocaleString('de-ch', { month: 'long' })+ `</div>
            <div class="title" style="font-size: 18px;">`+ "<ons-icon icon='ion-md-time'>  " +element.time + ` Uhr</div>
            <div class="title" style="font-size: 18px;">`+ "<ons-icon icon='ion-ios-pin'>  " +element.location + `</div>

            <div class="content">
              <p>`+ element.body + `</p>
            </div>
          </ons-card>
          <ons-card>
            <div class="content">
            <p style>Anmeldungen <b>`+ element.booked + ` von ` + element.participants + `</b></p>
            </div>
            
             <div class="progress">
                <div class="bar" style="width:`+ progressvalue + `%">
                    <p class="percent"><b>`+ progressvalue + `%</b></p>
                </div>
            </div>
            <br>
            
            ` + button + `

          </ons-card>`;
          

        });

    });
};




