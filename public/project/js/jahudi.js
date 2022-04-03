removeValue[i].addEventListener('click', function() {
    imgContainer[i].innerHTML = '';
    valueContainer[i].innerText = '';
    removeValue[i].style.display = "none";

    // Untuk Hapus File dalam FileList hehe
    if (i == 0) {
        if (fInput.files.length == 3 && fInput.files[1] != '' && fInput.files[2] != '' ) {
            const fileArray = [fInput.files[1], fInput.files[2]];
            const dt = new DataTransfer();
            dt.items.add(fileArray[0]);
            dt.items.add(fileArray[1]);
            fInput.files = dt.files;
            valueTotal.innerText = fInput.files.length + " files uploaded";
        } else if (fInput.files.length == 2 && fInput.files[1] != '' && fInput.files[0].name == fName0) {
            const fileArray = [fInput.files[1]];
            const dt = new DataTransfer();
            dt.items.add(fileArray[0]);
            fInput.files = dt.files;
            valueTotal.innerText = fInput.files.length + " file uploaded";
        } else if (fInput.files.length == 1 && fInput.files[0] != '' && fInput.files[0].name == fName0) {
            // const fileArray = [fInput.files[1]];
            const dt = new DataTransfer();
            // dt.items.add(fileArray[0]);
            fInput.files = dt.files;
            valueTotal.innerText = '';
        }
    } 

    if (i == 1) {
        if (fInput.files.length == 3 && fInput.files[0] != '' && fInput.files[2] != '') {
            const fileArray = [fInput.files[0], fInput.files[2]];
            const dt = new DataTransfer();
            dt.items.add(fileArray[0]);
            dt.items.add(fileArray[1]);
            fInput.files = dt.files;
            valueTotal.innerText = fInput.files.length + " files uploaded";
        } else if (fInput.files.length == 2 && fInput.files[1] != '' && fInput.files[0].name == fName) {
            const fileArray = [fInput.files[1]];
            const dt = new DataTransfer();
            dt.items.add(fileArray[0]);
            fInput.files = dt.files;
            valueTotal.innerText = fInput.files.length + " file uploaded";
        } else if (fInput.files.length == 2 && fInput.files[1].name == fName) {
            const fileArray = [fInput.files[0]];
            const dt = new DataTransfer();
            dt.items.add(fileArray[0]);
            fInput.files = dt.files;
            valueTotal.innerText = fInput.files.length + " file uploaded";
        }  else if (fInput.files.length == 1 && fInput.files[0] != '' && fInput.files[0].name == fName) {
            // const fileArray = [fInput.files[1]];
            const dt = new DataTransfer();
            // dt.items.add(fileArray[0]);
            fInput.files = dt.files;
            valueTotal.innerText = '';
        }
    }

    if (i == 2) {
        if (fInput.files.length == 3 && fInput.files[0] != '' && fInput.files[1] != '') {
            const fileArray = [fInput.files[0], fInput.files[1]];
            const dt = new DataTransfer();
            dt.items.add(fileArray[0]);
            dt.items.add(fileArray[1]);
            fInput.files = dt.files;
            valueTotal.innerText = fInput.files.length + " files uploaded";
        } else if (fInput.files.length == 2 && fInput.files[0] != '' && fInput.files[1].name == fName2 ) {
            const fileArray = [fInput.files[0]];
            const dt = new DataTransfer();
            dt.items.add(fileArray[0]);
            fInput.files = dt.files;
            valueTotal.innerText = fInput.files.length + " file uploaded";
        } else if (fInput.files.length == 1 && fInput.files[0] != '' && fInput.files[0].name == fName2  ) {
            // const fileArray = [fInput.files[1]];
            const dt = new DataTransfer();
            // dt.items.add(fileArray[0]);
            fInput.files = dt.files;
            valueTotal.innerText = '';
        }
    }

    // jika File List sudah kosong maka akan menjalankan:
    if (fInput.files.length == '') {
        subIcon.style.display = "block";
        subNotice.style.display = "block";
    }

});



function countdown() {

    var currentDate = new Date();
    var timesUp = new Date(timer.innerText);

    const totalSeconds = (timesUp - currentDate) / 1000;
    
    const h = Math.floor(totalSeconds / 3600) % 24;
    const m = Math.floor(totalSeconds / 60) % 60;
    const s = Math.floor(totalSeconds) % 60;

    hour.innerText = formatTime(h);
    minute.innerText = formatTime(m);
    second.innerText = formatTime(s);

    // hari ini pasti selesai

    if (hour.innerText == "00" && minute.innerText == "00" && second.innerText == "00") {
        modBackground.style.display = "flex";
        modText.innerText = "WAKTU HABIS!";
        submitBtn.style.display = "none";
        yesBtn.style.display = "none";
        noBtn.style.display = "none";
        modClose.style.display = "none";
        timeStop();
        // yesBtn.addEventListener('click', function() {
        //     modBackground.style.display = "none";
        // });
        cD.submit();
    }
}

// this help me
window.onload = function () {
    if (typeof history.pushState === "function") {
        history.pushState("jibberish", null, null);
        window.onpopstate = function() {
            history.pushState("newjibberish", null, null);
            modBackground.style.display = "flex";
            modText.innerText = "APAKAH ANDA YAKIN AKAN MENINGGALKAN QUIZ?";
            submitBtn.style.display = "none";
            yesBtn.style.display = "block";
            noBtn.style.display = "block";
            yesBtn.style.position = "absolute";
            yesBtn.style.top = "125px";
            yesBtn.style.right = "80px";

            yesBtn.addEventListener('click', function(e) {
                cD.submit();
                // window.location = "/siswa/kelas/index/" + id;
                
            });

            noBtn.addEventListener('click', function() {
                modBackground.style.display = "none";
            });
        };
    }
    else {
        var ignoreHashChange = true;
        window.onhashchange = function() {
            if (!ignoreHashChange) {
                ignoreHashChange = true;
                window.location.hash = Math.random();
            } else {
                ignoreHashChange = false;
            }
        }
    }
}

function formatTime(time) {
    // return time < 10? `0${time}` : time;
}

countdown();

var set = setInterval(countdown, 1000);

function timeStop() {
    clearInterval(set);
}
