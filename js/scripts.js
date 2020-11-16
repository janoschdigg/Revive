// Load Animation
$(document).ready(function (event) {
    $('#loading').show();
    setTimeout(function () {
        $('#loading').fadeOut();
    }, 300);
});






var activitylist = null;
var churchlist = null;

// Load Activities
$(document).ready(function (event) {
    reloadactivities();
   
});

function loadCategories()
{
    $.post("phpscripts/getdata.php?type=category", function (data) {

        var obj = JSON.parse(data);
        categories = obj;
        });
}

function reloadactivities()
{
    $.post("phpscripts/getdata.php?type=activity", function (data) {

        var obj = JSON.parse(data);
        activitylist = obj;
        printActivities(0);
    
        });
}

function getCategory(categories, id)
{
    categories.forEach(element =>{
        if(element.id == id)
        {
            
            catInfo = element;
        }
    });
}

function printCatInfo(){
    document.getElementById("category_info").classList.remove("hidden")
    document.getElementById("info_title").innerHTML = "<b>"+catInfo.name+":</b>";
    document.getElementById("info_text").innerHTML = catInfo.info;
}
var categories = null;
var catInfo = null;
var backgroundclass = '';

function printActivities(category)
{
    loadCategories();
    
    if(category == 0)
    {
        document.getElementById("category_info").classList.add("hidden");
    }

    if(category == 1)
    {
        getCategory(categories, 1);
        printCatInfo();
    }
    else if(category == 2)
    {
        getCategory(categories, 2);
        printCatInfo();
    }
    else if(category == 3)
    {
        getCategory(categories, 3);
        printCatInfo();
    }
    else if(category == 4)
    {
        getCategory(categories, 4);
        printCatInfo();
    }

    var container = document.getElementById("acitivities");

    container.innerHTML = "";
    
    activitylist.forEach(element => {
        var days = ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];
        var date = new Date(element.date);
        var dayName = days[date.getDay()];

        

        if(element.fcategoryID == 1)
        {
            backgroundclass = 'red';
        }

        else if(element.fcategoryID == 2){
            backgroundclass = 'yellow';
        }

        else if(element.fcategoryID == 3){
            backgroundclass = 'blue';
        }

        else if(element.fcategoryID == 4){
            backgroundclass = 'green';
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

function sendFeedback()
{
    name = document.getElementById('name_feedback').value;
    phone = document.getElementById('phone_feedback').value;
    feedback = document.getElementById('feedback').value;
    waiver = document.getElementById('waiver').checked;


    console.log(name);
    console.log(phone);
    console.log(feedback);
    console.log(waiver);
    $.post( "phpscripts/postdata.php?type=feedback", { name: name, phone: phone, feedback, feedback, waiver: waiver })
    .done(function( data ) {
        alert("Feedback gesendet!");
        window.open('index.html', '_self');

    });


}

function sendRegister(id)
{
    name = document.getElementById('name').value;
    phone = document.getElementById('phone').value;

    $.post("phpscripts/postdata.php?type=registration&id="+id+"&name="+name+"&phone="+phone, function (data) {
        
        if(data.includes('true')){
            alert("Du hast dich erfolgreich angemeldet!");
            window.open('index.html', '_self');
        }
        else
        {
            alert("Bitte alles ausfüllen!");
        }
    });
}

function register(id, name) {
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
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
  }
function getCookie(cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
      var c = ca[i];
      while (c.charAt(0) == ' ') {
        c = c.substring(1);
      }
      if (c.indexOf(name) == 0) {
        return c.substring(name.length, c.length);
      }
    }
    return "";
  }

function logout()
{
    if (confirm('Willst dich wirklich ausloggen?')) {
        document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "userid=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.open('index.html', '_self');      
    } 
   

}

function sendlogin(){
    username = document.getElementById('admin-user').value;
    password = document.getElementById('admin-pw').value;

    $.post( "phpscripts/postdata.php?type=login", { username: username, password: password })
    .done(function( data ) {
        var user = JSON.parse(data);
        if(typeof user[0].id !== 'undefined')
        {
            setCookie("userid", user[0].id, 360);
            setCookie("username", user[0].username, 360);
            setCookie("name", user[0].name, 360);

            alert("Login erfolgreich!");
            hideAlertDialog();

        }
       
    });
}

function login()
{
    var userid = getCookie("userid");
    if (userid != "") {
        var elements = document.querySelectorAll('.toolbar');
        for(var i=0; i<elements.length; i++){
            elements[i].style.background = "white";
        }
        logout();
    } else {
        var elements = document.querySelectorAll('.toolbar');
        for(var i=0; i<elements.length; i++){
            elements[i].style.background = "red !important";
        }
        createAlertDialog();
    }

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
       
            
            button ="";
            if(progressvalue < 100)
            {
                button = `<div class="btn" onclick="register(`+ element.id + `, '` + element.title + `')">Anmelden</div>`;
            }
            progressvalue = Math.round(progressvalue, 1);
            container.innerHTML += `<ons-card>
            <div class="hidden" id="datailID">`+ element.id + `</div>

            <div class="title"><b>`+ element.title + `</b></div>
            <div class="title" style="font-size: 18px; margin-bottom: 5px;"><ons-icon icon="ion-ios-calendar">  ` + dayName + " " + date.getDate()+". " + date.toLocaleString('de-ch', { month: 'long' })+ `</div>
            <div class="title" style="font-size: 18px;">`+ "<ons-icon icon='ion-ios-time'>  " +element.time + ` Uhr</div>
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

          </ons-card>
          <ons-card>
            <ons-list>

            <ons-list-item onclick="mail('`+ element.mail + `')">
                <div class="left">
                    <img class="list-item__thumbnail" src="images/churches/`+ element.logo + `">
                </div>
                <div class="center">
                    <span class="list-item__title">`+ element.name + `</span><span class="list-item__subtitle">`+ element.username + `</span>
                </div>
                <div class="right">
                <ons-icon icon='ion-ios-mail' style='font-size: 20px; color: gray;'>
               
                </div>
                </ons-list-item>
            </ons-list>

          </ons-card>
          `;

          if(element.fuserid == getCookie("userid"))
          {
            $.post("phpscripts/getdata.php?type=registration&id=" + element.id, function (data) {
                var html = ``;
                html += `
                <ons-card>
                    <ons-list>
                        <ons-list-header>Anmeldungen</ons-list-header>
                `;    

                var anmeldungen = JSON.parse(data);
                var anmeldeCounter = 1;
                anmeldungen.forEach(el => {
                    html += `
                    <ons-list-item>
                        <div class='left'>`+anmeldeCounter+`</div>
                        <div class='center'>`+el.name+`</div>
                        <div class='right'><a href="tel:`+el.phone+`">`+el.phone+`</a></div>
                    </ons-list-item>
                    `;
                    anmeldeCounter++;
                });

                html += `
                </ons-list>
            </ons-card>
            `;

            container.innerHTML += html;
            });
          }
          

        });

    });

   

};


function mail(email)
{
    window.location.href = "mailto:" + email;
}