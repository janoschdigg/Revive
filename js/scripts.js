// Load Animation
$(document).ready(function (event) {
    $('#loading').show();
    setTimeout(function () {
        $('#loading').fadeOut();
    }, 300);
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
        // myAlert("Feedback", "Dein Feedback wurde gesendet, danke.", "ok", "");
        alert('Feedback gesendet');
        window.open('index.html', '_self');

    });

}

function myAlert(title, text, action, actiontext)
{
    var dialog = document.getElementById('custom-dialog');

    if (dialog) {
      dialog.show();
    } else {
      ons.createElement('custom-dialog.html', { append: true })
        .then(function (dialog) {
          dialog.show();
        });
    }

    document.getElementById('custom-title').innerHTML = "<p>"+title+"</p>";
    document.getElementById('custom-content').innerHTML = "<p>"+text+"</p>";

    if(action == "ok")
    {
    document.getElementById('custom-buttons').innerHTML = `
    <ons-alert-dialog-button onclick="hideCustomDialog()">OK</ons-alert-dialog-button>
    `;
    }
    else{
        document.getElementById('custom-buttons').innerHTML = `
        <ons-alert-dialog-button onclick="hideCustomDialog()">Abbrechen</ons-alert-dialog-button>
        <ons-alert-dialog-button onclick="`+action+`">`+actiontext+`</ons-alert-dialog-button>
        `;
    }

    

   

}

function sendRegister(id)
{
    name = document.getElementById('name').value;
    phone = document.getElementById('phone').value;

    if (true) {
        $.post("phpscripts/postdata.php?type=registration&id="+id+"&name="+name+"&phone="+phone, function (data) {
    
            if(data.includes('true')){
                alert('Du hast dich erfolgreich angemeldet');
                window.open('index.html', '_self');
            }
            else
            {
                alert('Bitte alles ausfüllen!');            
            }
        });
    }

   
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
            <ons-input id="phone" type="tel" float maxlength="12" placeholder="Telefonnummer"></ons-input>
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


function mail(email)
{
    window.location.href = "mailto:" + email;
}