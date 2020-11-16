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

