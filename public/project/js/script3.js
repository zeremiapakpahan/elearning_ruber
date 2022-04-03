
// Dropdown Table Effect

const drop =  document.querySelectorAll('#drop');
const dropdownRow = document.querySelectorAll('.dropdown-row');

if ( $('#drop').length != '' ) {
    for (let i = 0; i < drop.length; i++) {
        drop[i].addEventListener('click', function() {
            dropdownRow[i].classList.toggle('drop');
        }); 
    }
}

//Presence Edit Effect

// const presenceEdit = document.querySelectorAll('#p-edit');
// const attendanceGroup = document.querySelectorAll('.a-group');
// const presenceForm = document.querySelectorAll('.presence-form');

// if ( $('#p-edit').length != '') {
//     for (let i = 0; i < presenceEdit.length; i++) {
//         presenceEdit[i].addEventListener('click', function() {
//             presenceForm[i].classList.toggle('exist');
//             attendanceGroup[i].classList.toggle('hide');
//         });
//     }
// }


// Member Form Effect

const addMember = document.getElementById('add-member');
const memberForm = document.querySelector('.member-form');

if ( $('#add-member').length != '') {
    addMember.addEventListener('click', function() {
        memberForm.classList.toggle('exist');
    });
}

// Class Detail Form Effect

const cdEdit = document.getElementById('cd-edit');
const detailGroup = document.querySelector('.detail-group');
const cdForm = document.querySelector('.cd-form');

if ( $('#cd-edit').length != '') {
    cdEdit.addEventListener('click', function() {
        detailGroup.classList.toggle('hide');
        cdForm.classList.toggle('exist');
    });
}

// Quiz Pilgan Preview's Nav Effect

const sNav = document.querySelector('.quiz-pilgan-nav span:nth-child(1)');
const sSection = document.querySelector('.quiz-pilgan-detail .submission-section');
const qpNav = document.querySelector('.quiz-pilgan-nav span:nth-child(2)');
const qppSection = document.querySelector('.qp-preview-section');

if ( $('.quiz-pilgan-nav span:nth-child(1)').length != '' && $('.quiz-pilgan-nav span:nth-child(2)').length != '' ) {
    sNav.addEventListener('click', function() {
        sNav.classList.add('active');
        qpNav.classList.remove('active');
        sSection.style.display = "block";
        qppSection.style.display = "none";
    });

    qpNav.addEventListener('click', function() {
        qpNav.classList.add('active');
        sNav.classList.remove('active');
        qppSection.style.display = "block";
        sSection.style.display = "none";
    });
}

// Quiz Essay Preview's Nav Effect

const sNav2 = document.querySelector('.quiz-essay-nav span:nth-child(1)');
const sSection2 = document.querySelector('.quiz-essay-detail .submission-section')
const qpNav2 = document.querySelector('.quiz-essay-nav span:nth-child(2)');
const qepSection = document.querySelector('.qe-preview-section');

if ( $('.quiz-essay-nav span:nth-child(1)').length != '' &&  $('.quiz-essay-nav span:nth-child(2)').length != '' ) {
    sNav2.addEventListener('click', function() {
        sNav2.classList.add('active');
        qpNav2.classList.remove('active');
        sSection2.style.display = "block";
        qepSection.style.display = "none";
    });

    qpNav2.addEventListener('click', function() {
        qpNav2.classList.add('active');
        sNav2.classList.remove('active');
        qepSection.style.display = "block";
        sSection2.style.display = "none";
    });
}


// Quiz Pilgan's Choice Effect

const choice = document.querySelectorAll('.choice span:nth-child(2)');
const trueChoice = document.querySelectorAll('.quiz-pilgan-detail .choice span:nth-child(3) input');
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
            const divLastChild = qnFirstChild.lastElementChild;

            checkedStyle[i].style.backgroundColor = "#9c9a9a";
            divLastChild.innerText = grandFC.innerText + " " + trueChoice[i].value;
        }
    }
}
choiceChecked();





// Show File-Image in File Container (komen tugas)

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

sorted.forEach( e => document.querySelector('.comment-container').append(e)

);


// Show Comment More Effect
if ( $('.next-btn button').length != '') {
    const next = document.querySelector('.next-btn button');
    const commentRow = document.querySelectorAll('.comment-row');
    const commentTotal = document.querySelector('.comment-total p');

    function showCommentMore() {

        commentTotal.innerText = commentRow.length;
        next.style.display = "none";

        if (commentRow.length > 2) {
            next.style.display = "block";
            for (let i = 2; i < commentRow.length; i++) {
                commentRow[i].style.display = "none";

                next.addEventListener('click', function() {
                    commentRow[i].style.display = "flex";
                    next.style.display = "none";
                });
            }
        }
    }
    showCommentMore();
}