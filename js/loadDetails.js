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
