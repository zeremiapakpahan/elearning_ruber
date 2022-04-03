const subIcon = document.querySelector('.sub-icon');
const subNotice = document.querySelector('.sub-notice');
const valueArea = document.querySelector('.value-area');
const removeValue = document.querySelectorAll('.v-item i');
const imgContainer = document.querySelectorAll('.v-item span');
const valueContainer = document.querySelectorAll('.v-item p');
const valueTotal = document.querySelector('.value-area>span');
const fInput = document.querySelector('.submission-form>div .file-input');

if ( $('.submission-form>div .file-input').length != '') {
    
    fInput.addEventListener('change', function() {

        subIcon.style.display = "none";
        subNotice.style.display = "none";

        // Membatasi hanya 3 File yang masuk
        if (fInput.files.length > 3) {
            const fileArray = [fInput.files[0], fInput.files[1], fInput.files[2]];
            const dt = new DataTransfer();
            dt.items.add(fileArray[0]);
            dt.items.add(fileArray[1]);
            dt.items.add(fileArray[2]);
            fInput.files = dt.files;
        }

        if (fInput.files.length == 1) {
            var total = fInput.files.length;
            valueTotal.innerText = total + " file uploaded";
        } else if (fInput.files.length > 1) {
            var total = fInput.files.length;
            valueTotal.innerText = total + " files uploaded";
        }

        for (let i = 0; i < fInput.files.length < 4; i++) {
            var files = fInput.files[i];
            var fileDesc = files.name;
            var lastIndex = fileDesc.lastIndexOf('.');
            var fileName = fileDesc.substring(0, lastIndex);
            var fileExt = fileDesc.substring(lastIndex);

            if (fileName.length > 12) {
                var sbstrFN = fileName.substring(0,10) + "...";
            } else {
                var sbstrFN = fileName;
            }

            if (fileExt == ".jpg" || fileExt == ".jpeg" || fileExt == ".png" ) {

                // fungsi agar saat upload ulang, upload an yang lama dihapus
                if (i == 0) {
                    imgContainer[1].innerHTML = '';
                    valueContainer[1].innerText = '';
                    removeValue[1].style.display = "none";

                    imgContainer[2].innerHTML = '';
                    valueContainer[2].innerText = '';
                    removeValue[2].style.display = "none";
                } else if (i == 0 && i == 1) {
                    imgContainer[2].innerHTML = '';
                    valueContainer[2].innerText = '';
                    removeValue[2].style.display = "none";
                }

                var url = URL.createObjectURL(files); //bandingkan dengan file reader
                removeValue[i].style.display = "block";
                imgContainer[i].innerHTML = '<img src="'+ url +'" alt="File">';
                valueContainer[i].innerText = sbstrFN + fileExt;

            } else if (fileExt == ".docx") {

                // fungsi agar saat upload ulang, upload an yang lama dihapus
                if (i == 0) {
                    imgContainer[1].innerHTML = '';
                    valueContainer[1].innerText = '';
                    removeValue[1].style.display = "none";

                    imgContainer[2].innerHTML = '';
                    valueContainer[2].innerText = '';
                    removeValue[2].style.display = "none";
                } else if (i == 0 && i == 1) {
                    imgContainer[2].innerHTML = '';
                    valueContainer[2].innerText = '';
                    removeValue[2].style.display = "none";
                }

                removeValue[i].style.display = "block";
                imgContainer[i].innerHTML = '<img src="/img/doc.png" alt="File">';
                valueContainer[i].innerText = sbstrFN + fileExt;

            } else if (fileExt == ".xlsx") {

                // fungsi agar saat upload ulang, upload an yang lama dihapus
                if (i == 0) {
                    imgContainer[1].innerHTML = '';
                    valueContainer[1].innerText = '';
                    removeValue[1].style.display = "none";

                    imgContainer[2].innerHTML = '';
                    valueContainer[2].innerText = '';
                    removeValue[2].style.display = "none";
                } else if (i == 0 && i == 1) {
                    imgContainer[2].innerHTML = '';
                    valueContainer[2].innerText = '';
                    removeValue[2].style.display = "none";
                }

                removeValue[i].style.display = "block";
                imgContainer[i].innerHTML = '<img src="/img/xls.png" alt="File">';
                valueContainer[i].innerText = sbstrFN + fileExt;

            } else if (fileExt == ".pptx") {

                // fungsi agar saat upload ulang, upload an yang lama dihapus
                if (i == 0) {
                    imgContainer[1].innerHTML = '';
                    valueContainer[1].innerText = '';
                    removeValue[1].style.display = "none";

                    imgContainer[2].innerHTML = '';
                    valueContainer[2].innerText = '';
                    removeValue[2].style.display = "none";
                } else if (i == 0 && i == 1) {
                    imgContainer[2].innerHTML = '';
                    valueContainer[2].innerText = '';
                    removeValue[2].style.display = "none";
                }

                removeValue[i].style.display = "block";
                imgContainer[i].innerHTML = '<img src="/img/ppt.png" alt="File">';
                valueContainer[i].innerText = sbstrFN + fileExt;

            } else if (fileExt == ".pdf") {

                // fungsi agar saat upload ulang, upload an yang lama dihapus
                if (i == 0) {
                    imgContainer[1].innerHTML = '';
                    valueContainer[1].innerText = '';
                    removeValue[1].style.display = "none";

                    imgContainer[2].innerHTML = '';
                    valueContainer[2].innerText = '';
                    removeValue[2].style.display = "none";
                } else if (i == 0 && i == 1) {
                    imgContainer[2].innerHTML = '';
                    valueContainer[2].innerText = '';
                    removeValue[2].style.display = "none";
                }

                removeValue[i].style.display = "block";
                imgContainer[i].innerHTML = '<img src="/img/pdf.png" alt="File">';
                valueContainer[i].innerText = sbstrFN + fileExt;

            } else {

                // fungsi agar saat upload ulang, upload an yang lama dihapus
                if (i == 0) {
                    imgContainer[1].innerHTML = '';
                    valueContainer[1].innerText = '';
                    removeValue[1].style.display = "none";

                    imgContainer[2].innerHTML = '';
                    valueContainer[2].innerText = '';
                    removeValue[2].style.display = "none";
                } else if (i == 0 && i == 1) {
                    imgContainer[2].innerHTML = '';
                    valueContainer[2].innerText = '';
                    removeValue[2].style.display = "none";
                }
                
                removeValue[i].style.display = "block";
                imgContainer[i].innerHTML = '<img src="/img/file.png" alt="File">';
                valueContainer[i].innerText = sbstrFN + fileExt;

            }

            
            if (i == 0) {
                const fName0 = fInput.files[0].name;

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

                    // jika File List sudah kosong maka akan menjalankan:
                    if (fInput.files.length == '') {
                        subIcon.style.display = "block";
                        subNotice.style.display = "block";
                    }
    
                });
            }

            if (i == 1) {
                const fName = fInput.files[1].name; // untuk menangkap nama fInput.file[1] terlebih dahulu, dan digunakan di bawah sebagai pembanding

                removeValue[i].addEventListener('click', function() {
                    imgContainer[i].innerHTML = '';
                    valueContainer[i].innerText = '';
                    removeValue[i].style.display = "none";

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

                    // jika File List sudah kosong maka akan menjalankan:
                    if (fInput.files.length == '') {
                        subIcon.style.display = "block";
                        subNotice.style.display = "block";
                    }
    
                });
            }

            if (i == 2) {
                const fName2 = fInput.files[2].name;

                removeValue[i].addEventListener('click', function() {
                    imgContainer[i].innerHTML = '';
                    valueContainer[i].innerText = '';
                    removeValue[i].style.display = "none";

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
            }
            
        }

    });

}

// Quiz Pilgan's Choice Effect (bagian siswa)

const ch = document.querySelectorAll('.qs-choice span:nth-child(2)');
const stCh = document.querySelectorAll('.qs-choice span:nth-child(3) input');
const chStyle = document.querySelectorAll('.ch-style');
const tc = document.querySelectorAll('.qs-choice span:nth-child(5) input');
const point = document.querySelectorAll('.qs-row>span:nth-child(6) .input-section:nth-child(1)');
const nilai = document.querySelectorAll('.qs-row>span:nth-child(6) .input-section:nth-child(2)');

if ( $('.qs-choice span:nth-child(3) input').length != '' ) {
    for (let i = 0; i < stCh.length; i++) {
        stCh[i].addEventListener('change', function() {
            const parent = stCh[i].parentElement;
            const grand = parent.parentElement;
            const grandgrand = grand.parentElement;
            const ggFc = grandgrand.firstElementChild;

            const ggSc = ggFc.nextElementSibling;
            const ggScFc = ggSc.firstElementChild;
            const ggScSc = ggScFc.nextElementSibling;
            const ggScTc = ggScSc.nextElementSibling;
            const ggScTcFc = ggScTc.firstElementChild;
            const ggScLc = ggScTc.nextElementSibling;

            const ggTc = ggSc.nextElementSibling;
            const ggTcFc = ggTc.firstElementChild;
            const ggTcSc = ggTcFc.nextElementSibling;
            const ggTcTc = ggTcSc.nextElementSibling;
            const ggTcTcFc = ggTcTc.firstElementChild;
            const ggTcLc = ggTcTc.nextElementSibling;

            const ggFrc = ggTc.nextElementSibling;
            const ggFrcFc = ggFrc.firstElementChild;
            const ggFrcSc = ggFrcFc.nextElementSibling;
            const ggFrcTc = ggFrcSc.nextElementSibling;
            const ggFrcTcFc = ggFrcTc.firstElementChild;
            const ggFrcLc = ggFrcTc.nextElementSibling

            const ggLc = ggFrc.nextElementSibling;
            const ggLcFc = ggLc.firstElementChild;
            const ggLcSc = ggLcFc.nextElementSibling;
            const ggLcTc = ggLcSc.nextElementSibling;
            const ggLcTcFc = ggLcTc.firstElementChild;
            const ggLcLc = ggLcTc.nextElementSibling;

            const ggSxc = grandgrand.lastElementChild;
            const ggSxcFc = ggSxc.firstElementChild;
            const ggSxcSc = ggSxcFc.nextElementSibling;

            if (stCh[i].checked == true) {
                var val = ch[i].innerText;
                stCh[i].value = val;

                chStyle[i].style.backgroundColor = "#9c9a9a";

                if (ggScSc.innerText != ch[i].innerText ) {
                    ggScTcFc.checked = false;
                    ggScTcFc.value = '';
                    ggScLc.style.backgroundColor = "";
                }

                if (ggTcSc.innerText != ch[i].innerText ) {
                    ggTcTcFc.checked = false;
                    ggTcTcFc.value = '';
                    ggTcLc.style.backgroundColor = "";
                }

                if (ggFrcSc.innerText != ch[i].innerText ) {
                    ggFrcTcFc.checked = false;
                    ggFrcTcFc.value = '';
                    ggFrcLc.style.backgroundColor = "";
                }

                if (ggLcSc.innerText != ch[i].innerText ) {
                    ggLcTcFc.checked = false;
                    ggLcTcFc.value = '';
                    ggLcLc.style.backgroundColor = "";
                }

                if (stCh[i].value == tc[i].value ) {
                    ggSxcSc.value = ggSxcFc.value;
                }
            }

            //belom selesai jok

            if (stCh[i].checked == false) {
                stCh[i].value = '';
                chStyle[i].style.backgroundColor = "";
                ggSxcSc.value = '';
            }



        });
    }
}

// ini dak work jok

// Quiz Pilgan Notice (Modal) Effect

const qSection = document.querySelector('.question-section');
const qpNotice = document.querySelector('.qp-notice');
const formQp = document.querySelector('.qs-content form');
const sendButton = document.querySelector('.qs-content form>span button');
const modText = document.querySelector('.modal-body span');
const submitBtn = document.querySelector('.modal-body button#submit');
const yesBtn = document.querySelector('.modal-body button#yes');
const noBtn = document.querySelector('.modal-body button#no');
const modBackground = document.querySelector('.modal-background');
const modClose = document.querySelector('.modal-header i');

if ( $('.qs-content form>span button').length != '' ) {
    sendButton.addEventListener('click', function() {
        modBackground.style.display = "flex";
        modText.innerText = "APAKAH ANDA YAKIN AKAN MENYELESAIKAN QUIZ?";
        submitBtn.style.display = "block";
        yesBtn.style.display = "none";
        noBtn.style.display = "none";
    });
}

if ( $('.modal-header i').length != '' ) {
    modClose.addEventListener('click', function() {
        modBackground.style.display = "none";
    });
}

if ( $('.modal-body button#submit').length != '' ) {
    submitBtn.addEventListener('click', function() {
        // sendButton.setAttribute('type', 'submit');
        formQp.submit();
    });
}


// Countdown Quiz Timer Function

if ( $('.qs-header>span:nth-child(2)').length != '' )  {
    const timer = document.querySelector('.qs-header>span:nth-child(2)');
    const cD = document.querySelector('.countdown');
    const hour = document.querySelector('.h');
    const minute = document.querySelector('.m');
    const second = document.querySelector('.s');
    const id = document.querySelector('.hidden').value;

    function myFunct() {

        // penting untuk membuat countdown yang efisien
        var fullTime = timer.innerText;
        var timeArray = fullTime.split(' ');
        var yr = parseInt(timeArray[0]);
        var mnt = parseInt(timeArray[1]);
        var dy = parseInt(timeArray[2]);
        var hr = parseInt(timeArray[3]);
        var mns = parseInt(timeArray[4]);
        var timesUp = new Date(yr, mnt - 1, dy, hr, mns);

        
        $('.full-time').countdown({until: timesUp, padZeroes: true , compact: true, onExpiry: timesOut, format: 'HMS'});

        function timesOut() {
            modBackground.style.display = "flex";
            modText.innerText = "WAKTU HABIS!";
            submitBtn.style.display = "none";
            yesBtn.style.display = "block";
            yesBtn.textContent = "Tutup";
            yesBtn.style.position = "relative";
            yesBtn.style.top = "0";
            yesBtn.style.right = "0";
            noBtn.style.display = "none";
            modClose.style.display = "none";
            yesBtn.addEventListener('click', function() {
                cD.submit();
                modBackground.style.display = "none";
            });
        }
    }
    myFunct();

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

    
}


// khusus untuk halanan quiz pilgan siswa
// Quiz Pilgan's Choice Effect

const choice = document.querySelectorAll('.choice span:nth-child(2)');
const studentChoice = document.querySelectorAll('.quiz-pilgan-page .choice span:nth-child(3) input');
const trueChoice = document.querySelectorAll('.choice .true-choice input');
const checkedStyle = document.querySelectorAll('.checked-style');

function choiceChecked() {
    for (let i = 0; i < trueChoice.length; i++) {
        if (trueChoice[i].value == choice[i].innerText) {
            trueChoice[i].checked = true;
            const parent = trueChoice[i].parentElement;
            const grand = parent.parentElement;
            const grandFC = grand.firstElementChild;
            const grandGrand = grand.parentElement;
            const lastChild = grandGrand.lastElementChild;
            const qnFirstChild = lastChild.firstElementChild;
            const nextSibling = qnFirstChild.nextElementSibling;
            const divLastChild = nextSibling.lastElementChild;

            divLastChild.innerText = grandFC.innerText + " " + trueChoice[i].value;
        }

        if (studentChoice[i].value == choice[i].innerText) {
            studentChoice[i].checked = true;
            checkedStyle[i].style.backgroundColor = "#9c9a9a";
        }

        if (studentChoice[i].value != trueChoice[i].value) {
            const parent = studentChoice[i].parentElement;
            const grand = parent.parentElement;
            const grandGrand = grand.parentElement;
            const lastChild = grandGrand.lastElementChild;
            const qnFirstChild = lastChild.firstElementChild;

            qnFirstChild.innerText = "Jawaban Anda Salah";
            lastChild.style.backgroundColor = "#f8d7da";
        } else {
            const parent = studentChoice[i].parentElement;
            const grand = parent.parentElement;
            const grandGrand = grand.parentElement;
            const lastChild = grandGrand.lastElementChild;
            const qnFirstChild = lastChild.firstElementChild;

            qnFirstChild.innerText = "Jawaban Anda Benar";
        }

    }
}
choiceChecked();





