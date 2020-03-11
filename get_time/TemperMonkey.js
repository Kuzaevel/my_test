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
    btnMorning.value = "btnMorning";
    btnMorning.onclick = function() {getData();}
    foundTrNext.appendChild(btnMorning);

    var btnEvening = document.createElement('input');
    btnEvening.type = "button";
    btnEvening.className = "btn";
    btnEvening.value = "btnEvening";
    btnEvening.onclick = function() {getData();}
    foundTrNext.appendChild(btnEvening);

    function send_answer(answer){
        var url = 'http://vendorpa/srm/my_test/get_time/gettime.php';
        var data = { answer: answer};

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
        var searchText = "Итого отработано за день: ";
        var found;
        for (var i = 0; i < spanTags.length; i++) {
            if (spanTags[i].textContent == searchText) {
                found = spanTags[i+1].textContent;
                break;
            }
        }
        send_answer("Worked_time, " + found);
        console.log(found)
    }

    var min = 1000 * 60;
    var isPaused = false;
    var time = 0;
    var researchPause = 15*min;
    var delay = 1;
    var answer = "";

    function load() {
        d = new Date();
        var h = d.getHours();
        var m = d.getMinutes();
        time++;
        console.log( "Circle - " + h + " : " + m );

        if ( h == 8 ) {
            isPaused = true;
            console.log("Morning - " + h + " : " + m);
            console.log("Set paused and wait to 9.15");
            delay = 60 - m + 15;
            console.log("Will be reloaded after " + delay + "min");
            setTimeout( function() {
                location.reload();
            }, delay*min);
        }

        if( h == 9 || h == 10 ) {
            isPaused = true;
            console.log("Morning - " + h + ":" + m);
            console.log("Set paused becouse 9 hours")
            answer = getMorning();
            send_answer(answer);
            if ( answer == "Morning_BAD" ) {
                console.log("Will be reloaded after 15min");
                setTimeout( function() {
                    location.reload();
                }, 15*min );
            } else {
                setTimeout( function() {
                    isPaused = false;
                }, 240*min );
            }
        }

        if ( h >= 11 && h < 17 ) {
            researchPause = 30*min;
            console.log("Set ResearchPause - 30*min")
        }

        if ( h == 17 ) {
            isPaused = true;
            console.log("Evening - " + h + ":" + m);
            console.log("Set paused and wait to 17.45")
            if(m < 45) {
                delay = 45 - m;
                console.log("Will be reloaded after " + delay + "min");
                setTimeout( function() {
                    location.reload();
                }, delay*min);
            } else {
                answer = getEvening();
                send_answer(answer);
                if ( answer == "Evening_BAD" ) {
                    console.log("Will be reloaded after 7min");
                    setTimeout( function() {
                        location.reload();
                    }, 7*min );
                } else {
                    send_answer(getData());
                    setTimeout( function() {
                        isPaused = false;
                    }, 240*min );
                }
            }
        }

        if( h == 18 ){
            isPaused = true;
            console.log("Evening - " + h + ":" + m);
            console.log("Set paused becouse 18 hours")
            answer = getEvening();
            send_answer(answer);
            if ( answer == "Evening_BAD" ) {
                console.log("Will be reloaded after 7min");
                setTimeout( function() {
                    location.reload();
                }, 7*min );
            } else {
                send_answer(getData());
                setTimeout( function() {
                    isPaused = false;
                }, 240*min );
            }
        }

        if ( h >= 19 || h < 8 ) {
            researchPause = 45*min;
            console.log("ResearchPause - 45*min")
        }
    }

    setTimeout( function() {
        load();
        setInterval(function() {
            if(!isPaused) {
                load();
            } else {
                console.log('is paused');
            }
        }, researchPause);

    }, 20000);

    /*setInterval(function() {
        console.log('tt');
    }, 5000);*/


})();