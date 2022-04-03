// khusus untuk halanan hasil quiz pilgan siswa
// Quiz Pilgan's Choice Effect

const choice = document.querySelectorAll('.choice span:nth-child(2)');
const studentChoice = document.querySelectorAll('.qp-result .choice span:nth-child(3) input');
const trueChoice = document.querySelectorAll('.true-choice input');
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


// Quiz Essay Grade Process Effect

const checkPoint = document.querySelectorAll('.check-point input');
const cpStyle = document.querySelectorAll('.check-point span');
const pointColumn = document.querySelectorAll('.point .grade input');
const point = document.querySelectorAll('.point>input');

function pointTransfer() {
    for (let i = 0; i < checkPoint.length; i++) {
        
        // Khusus Untuk Bagian Edit Penilaian Quiz Essay Siswa (Guru)
        $(document).ready(function() {
            if (checkPoint[i].checked == true ) {
                cpStyle[i].style.backgroundColor = "#9c9a9a";
            } 
        });
        checkPoint[i].addEventListener('change', function() {
            if (checkPoint[i].checked == true ) {
                pointColumn[i].value = point[i].value;
                cpStyle[i].style.backgroundColor = "#9c9a9a";
            } 
            
            if (checkPoint[i].checked == false) {
                pointColumn[i].value = "";
                cpStyle[i].style.backgroundColor = "";
            }
        });
    }
}
pointTransfer();

// Quiz Notice (Modal) Effect

const qpButton = document.querySelector('.quiz-pilgan-section#siswa-section .qps-db');
const qp = document.getElementById('qp');
const qeButton = document.querySelector('.quiz-essay-section#siswa-section .qes-db');
const qe = document.getElementById('qe');
const modBackground = document.querySelector('.modal-background');
const modClose = document.querySelector('.modal-header i');

if ( $('.quiz-pilgan-section#siswa-section .qps-db').length != '' && $('.quiz-pilgan-section#siswa-section .qps-db').text() == "Kerjakan" ) {
    qpButton.addEventListener('click', function() {
        modBackground.style.display = "flex";
        qp.style.display ="flex";
        qe.style.display ="none";
    });
}

if ( $('.quiz-essay-section#siswa-section .qes-db').length != '' && $('.quiz-essay-section#siswa-section .qes-db').text() == "Kerjakan") {
    qeButton.addEventListener('click', function() {
        modBackground.style.display = "flex";
        qp.style.display ="none";
        qe.style.display ="flex";
    });
}

// if  ( $('.modal-background').length != '' ) {
//     modBackground.addEventListener('click', function() {
//         modBackground.style.display = "none";
//     });
// }

if ( $('.modal-header i').length != '' ) {
    modClose.addEventListener('click', function() {
        modBackground.style.display = "none";
    });
}

// Print To PDF Function
const printBtn = document.querySelector('.print-section .btn-section');
const canvas = document.querySelector('.table-container');
const studName = document.querySelector('.table-container h3');

if ( $('.print-section .btn-section').length != '' ) {
    printBtn.addEventListener('click', function() {

        event.preventDefault();

        var opt = {
            margin:         1,
            filename:       'Kegiatan Belajar '+studName.innerText+'.pdf',
            image:          {type: 'jpeg', quality: 0.98},
            html2canvas:    {scale: 2},
            jsPDF:          {unit: 'in', format: 'letter', orientation: 'portrait'}
        };

        html2pdf().set(opt).from(canvas).save();


    });
}

// Grade and Point Calculation
const grade = document.querySelectorAll('.nilai');
const poin = document.querySelectorAll('.poin');
const gradeC = document.getElementById('grade-c');
const poinC = document.getElementById('poin-c');

function calc() {
    var sumG = 0;
    $('.nilai').each(function() {
        sumG += Number($(this).text());
    });

    // var nG = $( ".nilai:contains(' ')" );

    // $('#grade-c').text(Math.round(sumG/(grade.length - nG.length)));
    
    $('#grade-c').text(Math.round(sumG/grade.length));

    //untuk yang di atas, kalau tugas atau kuis kosong, grade tidak dikurangi jumlahnya, atur lagi nanti.

    var sumP = 0;
    $('.poin').each(function() {
        sumP += Number($(this).text());
    });
    
    $('#poin-c').text(sumP);
}
calc();


// Set Percentage Bar Width Function

const percentage = document.querySelectorAll('.percentage');
const percentageBar = document.querySelectorAll('.percentage-bar');

function setWidthAttr() {

    for (let i = 0; i < percentage.length; i++) {
        percentageBar[i].style.width = percentage[i].innerText;
    }

}
setWidthAttr();


// Dropdown Table Effect (halaman admin)

const drop =  document.querySelectorAll('#drop');
const dropdownRow = document.querySelectorAll('.dropdown-row');

if ( $('#drop').length != '' ) {
    for (let i = 0; i < drop.length; i++) {
        drop[i].addEventListener('click', function() {
            dropdownRow[i].classList.toggle('drop');
        }); 
    }
}


// Show File-Image in File Container (index kelas guru)

const fic = document.querySelectorAll('#file-image-container');
const fl = document.querySelectorAll('#file-link span:nth-child(2)');

function showFileImage() {
    for (let i = 0; i < fl.length; i++) {
        var filePath = fl[i].innerText;
        var nameArray = filePath.split('/');
        var fileName = nameArray[2].toString();
        var lastIndex = fileName.lastIndexOf(".")
        var fileExt = fileName.substring(lastIndex);

        if (fileExt == '.jpg' || fileExt == '.jpeg' || fileExt == '.png') {
            fic[i].innerHTML = '<img src="/img/image.png" alt="File" >';
            fl[i].innerText = fileName;
        } else if (fileExt == '.docx') {
            fic[i].innerHTML = '<img src="/img/doc.png" alt="File" >';
            fl[i].innerText = fileName;
        } else if (fileExt == '.xlsx') {
            fic[i].innerHTML = '<img src="/img/xls.png" alt="File" >';
            fl[i].innerText = fileName;
        } else if (fileExt == '.pptx') {
            fic[i].innerHTML = '<img src="/img/ppt.png" alt="File" >';
            fl[i].innerText = fileName;
        } else if (fileExt == '.pdf') {
            fic[i].innerHTML = '<img src="/img/pdf.png" alt="File" >';
            fl[i].innerText = fileName;
        } else {
            fic[i].innerHTML = '<img src="/img/file.png" alt="File" >';
            fl[i].innerText = fileName;
        }

        // Jika tinggi nya berubah, maka akan menjalankan:

        if ($('#file-link').height() > 23) {
            fl[i].style.alignItems = 'flex-start';
        }
        
    }
}
showFileImage();


// Dynamic Textbox's Height

const taSection = document.querySelectorAll('.choice .ta-section');
const radio = document.querySelectorAll('.true input');

function  dynamicHeight() {
    if ( $('.choice .ta-section').length != '' ) {
        
        for (let i = 0; i < taSection.length; i++) {
            taSection[i].addEventListener('input', function() {
                if (taSection[i].value != '' ) {
                    var scrollHeight = taSection[i].scrollHeight;
                    var add = scrollHeight + 4;
                    taSection[i].style.height = add + "px";
                } else if (taSection[i].value == '' ) {
                    taSection[i].style.height = "28px"
                }
                
            });
        
        }
    }
}
dynamicHeight();

// Send Value Function

function sendValue() {

    if ( $('.choice .ta-section').length != '' ) {
        for (let i = 0; i < taSection.length; i++) {
            taSection[i].addEventListener('change', function() {
                radio[i].value = taSection[i].value;
            });
        }
    }

}
sendValue();


if (window.location.href.indexOf('guru/kelas/edit-quiz-pilgan/') != -1) {
    function checkedTrue() {
        for (let i = 0; i < taSection.length; i++) {
            if (taSection[i].value == radio[i].value) {
                radio[i].checked = true;
            }

            if ( $('.true input').length != '') {
                radio[i].addEventListener('change', function() {
                    if (radio[i].checked == false) {
                        radio[i].value = '';
                    } else if (radio[i].checked == true) {
                        radio[i].value = taSection[i].value;
                    }
                });
            }
        }
    }
    checkedTrue();
}

if (window.location.href.indexOf('guru/kelas/index/') != -1) {
    //Reset Form Function (Quiz Pilgan)

    const reset = document.querySelector('.quiz-pilgan .btn-group .btn-section:nth-child(1)');
    const quizPilgan = document.querySelector('.quiz-pilgan');

    if ( $('.quiz-pilgan .btn-group .btn-section:nth-child(1)').length != '' ) {
        reset.addEventListener('click', function() {
            quizPilgan.reset();
        });
    }

    //Reset Form Function (Quiz Essay)

    const reset2 = document.querySelector('.quiz-essay .btn-group .btn-section:nth-child(1)');
    const quizEssay = document.querySelector('.quiz-essay');

    if ( $('.quiz-essay .btn-group .btn-section:nth-child(1)').length != '' ) {
        reset2.addEventListener('click', function() {
            quizEssay.reset();
        });
    }
}


// Send URL Function

const qpLinkBtn = document.querySelector('.modal-body a:nth-child(2)');
const qeLinkBtn = document.querySelector('.modal-body a:nth-child(3)');

const qpLinkCont = document.querySelectorAll('.quiz-pilgan-section#siswa-section .qps-db');
const qeLinkCont = document.querySelectorAll('.quiz-essay-section#siswa-section .qes-db');

if ( $('.quiz-pilgan-section#siswa-section .qps-db').length != '' && $('.quiz-pilgan-section#siswa-section .qps-db').text() == "Kerjakan" ) {
    for (let i = 0; i < qpLinkCont.length; i++) {
        qpLinkCont[i].addEventListener('click', function() {
            var link = qpLinkCont[i].getAttribute("href");
            qpLinkCont[i].removeAttribute("href");
            qpLinkBtn.setAttribute("href", link);
        });
        
    }
}

if ( $('.quiz-essay-section#siswa-section .qes-db').length != '' && $('.quiz-essay-section#siswa-section .qes-db').text() == "Kerjakan" ) {
    for (let i = 0; i < qeLinkCont.length; i++) {
        qeLinkCont[i].addEventListener('click', function() {
            var link = qeLinkCont[i].getAttribute("href");
            qeLinkCont[i].removeAttribute("href");
            qeLinkBtn.setAttribute("href", link);
        });
        
    }
}

// Change Position Style

const commentBtn = document.querySelectorAll('.assignment-section#siswa-section a:nth-child(8)');
const submtBtn = document.querySelectorAll('.assignment-section#siswa-section a:nth-child(9)');

function changePosition() {
    for (let i = 0; i < commentBtn.length; i++) {
        // if (commentBtn[i].nextElementSibling != submtBtn[i] ) {
        //     commentBtn[i].style.margin = "0 20px";
        //     commentBtn[i].style.transition = "0";
        // }

        const parent = commentBtn[i].parentElement;
        const lc = parent.lastElementChild;
        const prevSib = lc.previousElementSibling;
        const nextPrevSib = prevSib.previousElementSibling;

        if (nextPrevSib != $('.assignment-section#siswa-section a:nth-child(9)')) {
            nextPrevSib.style.margin = "0 20px";
        }
    }
}
changePosition();



if (window.location.href.indexOf('guru/hasil-belajar-siswa/detail') != -1) {
    // Sort The Post in Index Kelas Guru

    // ini yang aku cari wkwk

    function comparator(a, b) {
        if (new Date(a.dataset.datetime) < new Date(b.dataset.datetime))
            return -1;
        if (new Date(a.dataset.datetime) > new Date(b.dataset.datetime))
            return 1;
        return 0;
    }

    var datetimes = document.querySelectorAll('[data-datetime]');
    var dtArray = Array.from(datetimes);

    let sorted = dtArray.sort(comparator);

    sorted.forEach( e => document.querySelector('.list-content').prepend(e)

    );

    // untuk membuat urutan nomor

    for (let i = 0; i < datetimes.length; i++) {
        
        var no = document.querySelectorAll('[data-datetime] td:nth-child(1)');
        no[i].innerText = i + 1;
    }
}

