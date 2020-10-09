// ==UserScript==
// @name         New Userscript
// @namespace    http://tampermonkey.net/
// @version      0.1
// @description  try to take over the world!
// @author       You
// @match        http://1csql-srv.novomet.ru/RS/Pages/ReportViewer.aspx?/SKUD/%D0%A0%D0%B0%D1%81%D1%88%D0%B8%D1%84%D1%80%D0%BE%D0%B2%D0%BA%D0%B0%20%D0%B4%D0%BD%D1%8F&EmployeeList=6666104028
// @grant        none
// ==/UserScript==


(function() {

    var link = document.querySelector("link[rel*='icon']") || document.createElement('link');
    link.type = 'image/x-icon';
    link.rel = 'shortcut icon';
    link.href = 'http://172.16.74.18/srm/other/img/earthtime.png';
    document.getElementsByTagName('head')[0].appendChild(link);

    'use strict';

    console.log('start');
    var d = new Date();

    var tdTagsNext = document.getElementsByTagName("span");
    var searchNext = "Сотрудники";
    var foundTrNext;

    for (var i = 0; i < tdTagsNext.length; i++) {
        if (tdTagsNext[i].textContent == searchNext) {
            foundTrNext = tdTagsNext[i];
            break;
        }
    }

    var btnMorning = document.createElement('input');
    btnMorning.type = "button";
    btnMorning.className = "btn";
    btnMorning.value = "getData";
    btnMorning.onclick = function() {getData();}
    foundTrNext.appendChild(btnMorning);

    var btnEvening = document.createElement('input');
    btnEvening.type = "button";
    btnEvening.className = "btn";
    btnEvening.value = "btnEvening";
    btnEvening.onclick = function() {getEvening();}
    foundTrNext.appendChild(btnEvening);

    function send_answer(answer){
        //var url = 'http://vendorpa/srm/other/get_time/gettime.php';

        var params = window
            .location
            .search
            .replace('?','')
            .split('&')
            .reduce(
                function(p,e){
                    var a = e.split('=');
                    p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                    return p;
                },
                {}
            );

        var emplId = params['EmployeeList'];
        console.log(emplId);

        var url = 'http://172.16.74.18/srm/other/get_time/gettime.php';

        var data = { answer: answer, emplid: emplId};

        try {
            fetch(url, {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
        } catch (error) {
            console.error('Ошибка:', error);
        }
    }

    function getMorning(){
        var tdTags = document.getElementsByTagName("td");
        var searchText = "№";
        var found;
        var flag = "Morning_BAD";
        for (var i = 0; i < tdTags.length; i++) {
            if (tdTags[i].textContent == searchText) {
                flag = "Morning_Good, " + tdTags[i+8].textContent.trim();
                break;
            }
        }
        console.log(flag);
        return flag;
    }

    function getEvening(){
        var ar=["1","2","3","4","5","6"];
        var tdTags = document.getElementsByTagName("td");
        var searchText = "№";
        var found;
        var flag = "Evening_BAD";
        var n;
        var flagNext = true;

        for (var i = 0; i < tdTags.length; i++) {
            if (tdTags[i].textContent == searchText) {
                found = tdTags[i+7]
                break;
            }
        }

        if(ar.includes(found.textContent)) {
            n = i+7;
            var k = n;
            while(flagNext) {
                if (ar.includes(tdTags[n].textContent)){
                    k = n;
                    n = n + 7;
                } else {
                    flagNext = false;
                    break;
                }
            }

            if(tdTags[k+5].textContent.trim()!=""){
                flag = "Evening_Good, " + tdTags[k+2].textContent.trim();
            }

        }
        console.log(flag);
        return flag;
    }


    function getData(){
        var spanTags = document.getElementsByTagName("span");
        var tdTags = document.getElementsByTagName("td");

        var searchTextIn = "№";
        var searchTextOut = "";
        var searchTextTotal = "Итого отработано за день: ";
        var foundIn;
        var foundOut;
        var foundTotal;

        for (var i = 0; i< tdTags.length; i++) {
            if (tdTags[i].textContent == searchTextIn) {
                foundIn = tdTags[i + 8].textContent;
                break;
            }
        }

        for ( i = 0; i < spanTags.length; i++) {
            if (spanTags[i].textContent == searchTextTotal) {
                foundTotal = spanTags[i+1].textContent;
                break;
            }
        }
        send_answer( "Entry time, " + foundIn + "   Worked_time, " + foundTotal);
        console.log("Entry time, " + foundIn);
        console.log("Worked_time, "+foundTotal);
    }

    function getTotalForOneDay(){
        var spanTags = document.getElementsByTagName("span");
        var searchTextTotal = "Итого отработано за день: ";
        var foundTotal;

        for ( i = 0; i < spanTags.length; i++) {
            if (spanTags[i].textContent == searchTextTotal) {
                foundTotal = spanTags[i+1].textContent;
                break;
            }
        }
        send_answer( "Worked_time, " + foundTotal);
        console.log("   Worked_time, " + foundTotal);
    }

    var min = 1000 * 60;
    var isPaused = false;
    var time = 0;
    var researchPause = 15*min;
    var delay = 1;
    var answer = "";

    var flag = false;

    function load() {
        d = new Date();
        var h = d.getHours();
        var m = d.getMinutes();
        var dh = ( '0' + h ).substr(-2);
        var dm = ( '0' + m ).substr(-2);

        time++;
        console.log( "Circle - " + dh + " : " + dm );

        if ( h == 8 ) {
            isPaused = true;
            console.log("Morning - " + dh + " : " + dm);
            console.log("Set paused and wait to 9:00");
            delay = 60 - m;
            console.log("Will be reloaded after " + delay + "min");
            setTimeout( function() {
                location.reload();
            }, delay*min);
        }

        if( h == 9 || h == 10 ) {
            isPaused = true;
            console.log("Morning - " + dh + ":" + dm);
            console.log("Set paused becouse " + dh + " hours")
            answer = getMorning();
            send_answer(answer);
            if ( answer == "Morning_BAD" ) {
                console.log("Will be reloaded after 10 min");
                setTimeout( function() {
                    location.reload();
                }, 10*min );
            } else {
                researchPause = 30*min;
                console.log('ResearchPause is ' + researchPause/min);
                console.log("Will be reloaded after 240 min");
                setTimeout( function() {
                    isPaused = false;
                }, 240*min );
            }
        }

        if ( h >= 11 && h < 17 ) {
            if( researchPause < 30*min ){
                researchPause = 30*min;
            } else {
                researchPause = researchPause + 1*min;
            }
            console.log("Set ResearchPause - " + researchPause/min + " min");
        }

        if ( h == 17 ) {
            isPaused = true;
            console.log("Evening - " + dh + ":" + dm);
            if(m < 45) {
                delay = 45 - m;
                console.log("Set paused and wait to 17.45")
                console.log("Will be reloaded after " + delay + " min");
                setTimeout( function() {
                    location.reload();
                }, delay*min);
            } else {
                answer = getEvening();
                send_answer(answer);
                if ( answer == "Evening_BAD" ) {
                    console.log("Will be reloaded after 7 min");
                    setTimeout( function() {
                        location.reload();
                    }, 7*min );
                } else {
                    console.log(answer);
                    getTotalForOneDay();
                    researchPause = 30*min;
                    setTimeout( function() {
                        isPaused = false;
                    }, 240*min );
                }
            }
        }

        if( h == 18 ){
            isPaused = true;
            console.log("Evening - " + dh + ":" + dm);
            console.log("Set paused becouse 18 hours")
            answer = getEvening();
            send_answer(answer);
            if ( answer == "Evening_BAD" ) {
                console.log("Will be reloaded after 7 min");
                setTimeout( function() {
                    location.reload();
                }, 7*min );
            } else {
                console.log(answer);
                getTotalForOneDay();
                researchPause = 30*min;
                setTimeout( function() {
                    isPaused = false;
                }, 240*min );
            }
        }

        if ( h >= 19 || h < 8 ) {
            researchPause = 60*min;
            console.log("ResearchPause - 45 min")
        }
    }

    setTimeout( function() {
        load();
        setInterval(function() {

            var dayOfWeek = new Date().getDay();
            //console.log(dayOfWeek);

            if(!isPaused) {
                if(dayOfWeek != 6 && dayOfWeek != 0) {
                    load();
                } else {
                    console.log('Weekend')
                }
            } else {
                var d = new Date();
                console.log( "Is paused " + ("0" + d.getHours()).substr(-2) + ":" + ( "0" + d.getMinutes()).substr(-2) );
            }
        }, researchPause);

    }, 20000);

    /*setInterval(function() {
        console.log('tt');
    }, 5000);*/


})();