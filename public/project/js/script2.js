// isi-kelas-dosen.html

//Deskripsi Kelas Style (Index Kelas Guru dan Siswa)

const deskripsi2 = document.querySelector('.deskripsi');
const styleElement2 = document.querySelector('.deskripsi-section div');
const guruStatus = document.querySelector('.status');

function colorChange2() {
    
    if ( $('.deskripsi').length != '' ) {
        
        if (deskripsi2.innerText == "TIK" || deskripsi2.innerText == "SBK" || deskripsi2.innerText == "English") {
            styleElement2.style.setProperty('--backgroundColor', '#4bb2f7');
            deskripsi2.style.backgroundColor = "#4bb2f7";
            guruStatus.style.backgroundColor = "#4bb2f7";
        } else if (deskripsi2.innerText == "Mandarin" || deskripsi2.innerText == "PJOK" || deskripsi2.innerText == "Musik") {
            styleElement2.style.setProperty('--backgroundColor', '#f74b76');
            deskripsi2.style.backgroundColor = "#f74b76";
            guruStatus.style.backgroundColor = "#f74b76";
        } else if (deskripsi2.innerText == "Matematika" || deskripsi2.innerText == "Agama" || deskripsi2.innerText == "Tipografi" || deskripsi2.innerText == "Bahasa Indonesia") {
            styleElement2.style.setProperty('--backgroundColor', '#7e3ffc');
            deskripsi2.style.backgroundColor = "#7e3ffc";
            guruStatus.style.backgroundColor = "#7e3ffc";
        } else if (deskripsi2.innerText == "IPA" || deskripsi2.innerText == "PKN" || deskripsi2.innerText == "IPS") {
            styleElement2.style.setProperty('--backgroundColor', '#b24bf7');
            deskripsi2.style.backgroundColor = "#b24bf7";
            guruStatus.style.backgroundColor = "#b24bf7";
        }

    }

}
colorChange2();


// Date Change Effect (Index Kelas Guru)

const labelSection = document.querySelectorAll('.label-section');
const date = document.querySelectorAll('.date');
const placeholder = document.querySelectorAll('.placeholder');
var userAgent = navigator.userAgent; //menentukan jenis browser

    
if ( $('.date').length != '' ) {
    for (let i = 0; i < date.length; i++) {
        // date[i].addEventListener("change", function() {
        //     if (date[i].value != '') {
        //         placeholder[i].style.opacity = "0";
        //         date[i].style.opacity = "1";
    
        //         if (userAgent.indexOf('Chrome') != -1 ) {
        //             date[i].classList.add('show-date');
        //         }
    
        //     } else if (date[i].value == '') {
        //         placeholder[i].style.opacity = "1";
        //         date[i].style.opacity = "0";
    
        //         if (userAgent.indexOf('Chrome') != -1 ) {
        //             date[i].style.opacity = "1";
        //             date[i].classList.remove('show-date');
        //         }
        //     }
        // });
    
        // baru jok
    
        if (userAgent.indexOf('Mozilla') != -1 ) {
            function changeStyleMozilla() {
                date[i].style.width = "145px";
                placeholder[0].style.display = "none";
                placeholder[1].style.transform = "translate(-90px, 0)";
                placeholder[2].style.transform = "translate(-90px, 0)";
            }
            changeStyleMozilla();
        } 
        
        if (userAgent.indexOf('Chrome') != -1 ) {
            function changeStyleChrome() {
                date[i].style.width = "115px";
                date[i].style.opacity = "1";
                placeholder[i].style.transform = "translate(60px, 0.5px)";
                placeholder[i].innerHTML = "00/00/0000";
                labelSection[i].classList.add('no-after');
            }
            changeStyleChrome();
        }
    }
}







// Reset Forms After Page Refresh

$(document).ready(function() {
    resetForms();
});

function resetForms() {
    for (let i = 0; i < document.forms.length; i++) {
        document.forms[i].reset();
    }
}

// Show File Input Value

const fileInput = document.querySelector('.file-input');
const fileInputValue = document.querySelectorAll('.file-input-value span');
const remVal = document.querySelectorAll('.file-input-value i');
const vN = document.querySelector('#vn');

if ( $('.file-input').length != '' ) {
    fileInput.addEventListener("change", function() {

        //Membatasi hanya 3 file yang masuk
        if (fileInput.files.length > 3) {
            const fileArray = [fileInput.files[0], fileInput.files[1], fileInput.files[2]];
            const dt = new DataTransfer();
            dt.items.add(fileArray[0]);
            dt.items.add(fileArray[1]);
            dt.items.add(fileArray[1]);
            fileInput.files = dt.files;
        }

        if (fileInput.files.length == 1) {
            var count = fileInput.files.length;
            vN.innerText = count + " file uploaded";
        } else if (fileInput.files.length > 1) {
            var count = fileInput.files.length;
            vN.innerText = count + " files uploaded ";
        }

        for (let i = 0; i < fileInput.files.length < 4; i++) {
            var files = fileInput.files[i];
            var fileDesc =  files.name;
            var lastIndex = fileDesc.lastIndexOf(".");
            var fileName = fileDesc.substring(0, lastIndex);
            var fileExt = fileDesc.substring(lastIndex);

            if (fileName.length > 12) {
                var sbstrFN = fileName.substring(0,12) + "...";
            } else {
                var sbstrFN = fileName;
            }

            if (i == 0) {
                remVal[1].style.display = "none";
                fileInputValue[1].innerText = '';

                remVal[2].style.display = "none";
                fileInputValue[2].innerText = '';
            } else if (i == 0 && i == 1) {
                remVal[2].style.display = "none";
                fileInputValue[2].innerText = '';
            }

            remVal[i].style.display = "block";
            fileInputValue[i].innerText =  sbstrFN + fileExt;

            if (i == 0) {
                const fName0 = fileInput.files[0].name;

                remVal[i].addEventListener('click', function() {
                    fileInputValue[i].innerText = '';
                    remVal[i].style.display = "none";
    
                    // Untuk Hapus File dalam FileList hehe
                    if (i == 0) {
                        if (fileInput.files.length == 3 && fileInput.files[1] != '' && fileInput.files[2] != '' ) {
                            const fileArray = [fileInput.files[1], fileInput.files[2]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            dt.items.add(fileArray[1]);
                            fileInput.files = dt.files;
                            vN.innerText = fileInput.files.length + " files uploaded";
                        } else if (fileInput.files.length == 2 && fileInput.files[1] != '' && fileInput.files[0].name == fName0) {
                            const fileArray = [fileInput.files[1]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            fileInput.files = dt.files;
                            vN.innerText = fileInput.files.length + " file uploaded";
                        } else if (fileInput.files.length == 1 && fileInput.files[0] != '' && fileInput.files[0].name == fName0) {
                            // const fileArray = [fInput.files[1]];
                            const dt = new DataTransfer();
                            // dt.items.add(fileArray[0]);
                            fileInput.files = dt.files;
                            vN.innerText = '';
                        }
                    } 

                });
            }

            if (i == 1) {
                const fName = fileInput.files[1].name; // untuk menangkap nama fInput.file[1] terlebih dahulu, dan digunakan di bawah sebagai pembanding

                remVal[i].addEventListener('click', function() {
                    fileInputValue[i].innerText = '';
                    remVal[i].style.display = "none";

                    if (i == 1) {
                        if (fileInput.files.length == 3 && fileInput.files[0] != '' && fileInput.files[2] != '') {
                            const fileArray = [fileInput.files[0], fileInput.files[2]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            dt.items.add(fileArray[1]);
                            fileInput.files = dt.files;
                            vN.innerText = fileInput.files.length + " files uploaded";
                        } else if (fileInput.files.length == 2 && fileInput.files[1] != '' && fileInput.files[0].name == fName) {
                            const fileArray = [fileInput.files[1]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            fileInput.files = dt.files;
                            vN.innerText = fileInput.files.length + " file uploaded";
                        } else if (fileInput.files.length == 2 && fileInput.files[1].name == fName) {
                            const fileArray = [fileInput.files[0]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            fileInput.files = dt.files;
                            vN.innerText = fileInput.files.length + " file uploaded";
                        }  else if (fileInput.files.length == 1 && fileInput.files[0] != '' && fileInput.files[0].name == fName) {
                            // const fileArray = [fInput.files[1]];
                            const dt = new DataTransfer();
                            // dt.items.add(fileArray[0]);
                            fileInput.files = dt.files;
                            vN.innerText = '';
                        }
                    }
                });
            }

            if (i == 2) {
                const fName2 = fileInput.files[2].name;

                remVal[i].addEventListener('click', function() {
                    fileInputValue[i].innerText = '';
                    remVal[i].style.display = "none";

                    if (i == 2) {
                        if (fileInput.files.length == 3 && fileInput.files[0] != '' && fileInput.files[1] != '') {
                            const fileArray = [fileInput.files[0], fileInput.files[1]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            dt.items.add(fileArray[1]);
                            fileInput.files = dt.files;
                            vN.innerText = fileInput.files.length + " files uploaded";
                        } else if (fileInput.files.length == 2 && fileInput.files[0] != '' && fileInput.files[1].name == fName2 ) {
                            const fileArray = [fileInput.files[0]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            fileInput.files = dt.files;
                            vN.innerText = fileInput.files.length + " file uploaded";
                        } else if (fileInput.files.length == 1 && fileInput.files[0] != '' && fileInput.files[0].name == fName2  ) {
                            // const fileArray = [fInput.files[1]];
                            const dt = new DataTransfer();
                            // dt.items.add(fileArray[0]);
                            fileInput.files = dt.files;
                            vN.innerText = '';
                        }
                    }
                });
            }

        }
        //jangan lupo dibaekin jok
    });
}

// Show File Input Value (Penugasan)

const fileInput2 = document.querySelector('.form-assignment-section .file-input');
const fileInputValue2 = document.querySelectorAll('.form-assignment-section .file-input-value span');
const remVal2 = document.querySelectorAll('.form-assignment-section .file-input-value i');
const vN2 = document.querySelector('.form-assignment-section #vn');

if ( $('.file-input').length != '' ) {
    fileInput2.addEventListener("change", function() {

        //Membatasi hanya 3 file yang masuk
        if (fileInput2.files.length > 3) {
            const fileArray = [fileInput2.files[0], fileInput2.files[1], fileInput2.files[2]];
            const dt = new DataTransfer();
            dt.items.add(fileArray[0]);
            dt.items.add(fileArray[1]);
            dt.items.add(fileArray[1]);
            fileInput2.files = dt.files;
        }

        if (fileInput2.files.length == 1) {
            var count = fileInput2.files.length;
            vN2.innerText = count + " file uploaded";
        } else if (fileInput2.files.length > 1) {
            var count = fileInput2.files.length;
            vN2.innerText = count + " files uploaded ";
        }

        for (let i = 0; i < fileInput2.files.length < 4; i++) {
            var files = fileInput2.files[i];
            var fileDesc =  files.name;
            var lastIndex = fileDesc.lastIndexOf(".");
            var fileName = fileDesc.substring(0, lastIndex);
            var fileExt = fileDesc.substring(lastIndex);

            if (fileName.length > 12) {
                var sbstrFN = fileName.substring(0,12) + "...";
            } else {
                var sbstrFN = fileName;
            }

            if (i == 0) {
                remVal2[1].style.display = "none";
                fileInputValue2[1].innerText = '';

                remVal2[2].style.display = "none";
                fileInputValue2[2].innerText = '';
            } else if (i == 0 && i == 1) {
                remVal2[2].style.display = "none";
                fileInputValue2[2].innerText = '';
            }

            remVal2[i].style.display = "block";
            fileInputValue2[i].innerText =  sbstrFN + fileExt;

            if (i == 0) {
                const fName0 = fileInput2.files[0].name;

                remVal2[i].addEventListener('click', function() {
                    fileInputValue2[i].innerText = '';
                    remVal2[i].style.display = "none";
    
                    // Untuk Hapus File dalam FileList hehe
                    if (i == 0) {
                        if (fileInput2.files.length == 3 && fileInput2.files[1] != '' && fileInput2.files[2] != '' ) {
                            const fileArray = [fileInput2.files[1], fileInput2.files[2]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            dt.items.add(fileArray[1]);
                            fileInput2.files = dt.files;
                            vN2.innerText = fileInput2.files.length + " files uploaded";
                        } else if (fileInput2.files.length == 2 && fileInput2.files[1] != '' && fileInput2.files[0].name == fName0) {
                            const fileArray = [fileInput2.files[1]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            fileInput2.files = dt.files;
                            vN2.innerText = fileInput2.files.length + " file uploaded";
                        } else if (fileInput2.files.length == 1 && fileInput2.files[0] != '' && fileInput2.files[0].name == fName0) {
                            // const fileArray = [fInput.files[1]];
                            const dt = new DataTransfer();
                            // dt.items.add(fileArray[0]);
                            fileInput2.files = dt.files;
                            vN2.innerText = '';
                        }
                    } 

                });
            }

            if (i == 1) {
                const fName = fileInput2.files[1].name; // untuk menangkap nama fInput.file[1] terlebih dahulu, dan digunakan di bawah sebagai pembanding

                remVal2[i].addEventListener('click', function() {
                    fileInputValue2[i].innerText = '';
                    remVal2[i].style.display = "none";

                    if (i == 1) {
                        if (fileInput2.files.length == 3 && fileInput2.files[0] != '' && fileInput2.files[2] != '') {
                            const fileArray = [fileInput2.files[0], fileInput2.files[2]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            dt.items.add(fileArray[1]);
                            fileInput2.files = dt.files;
                            vN2.innerText = fileInput2.files.length + " files uploaded";
                        } else if (fileInput2.files.length == 2 && fileInput2.files[1] != '' && fileInput2.files[0].name == fName) {
                            const fileArray = [fileInput2.files[1]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            fileInput2.files = dt.files;
                            vN2.innerText = fileInput2.files.length + " file uploaded";
                        } else if (fileInput2.files.length == 2 && fileInput2.files[1].name == fName) {
                            const fileArray = [fileInput2.files[0]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            fileInput2.files = dt.files;
                            vN2.innerText = fileInput2.files.length + " file uploaded";
                        }  else if (fileInput2.files.length == 1 && fileInput2.files[0] != '' && fileInput2.files[0].name == fName) {
                            // const fileArray = [fInput.files[1]];
                            const dt = new DataTransfer();
                            // dt.items.add(fileArray[0]);
                            fileInput2.files = dt.files;
                            vN2.innerText = '';
                        }
                    }
                });
            }

            if (i == 2) {
                const fName2 = fileInput2.files[2].name;

                remVal2[i].addEventListener('click', function() {
                    fileInputValue2[i].innerText = '';
                    remVal2[i].style.display = "none";

                    if (i == 2) {
                        if (fileInput2.files.length == 3 && fileInput2.files[0] != '' && fileInput2.files[1] != '') {
                            const fileArray = [fileInput2.files[0], fileInput2.files[1]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            dt.items.add(fileArray[1]);
                            fileInput2.files = dt.files;
                            vN2.innerText = fileInput2.files.length + " files uploaded";
                        } else if (fileInput2.files.length == 2 && fileInput2.files[0] != '' && fileInput2.files[1].name == fName2 ) {
                            const fileArray = [fileInput2.files[0]];
                            const dt = new DataTransfer();
                            dt.items.add(fileArray[0]);
                            fileInput2.files = dt.files;
                            vN2.innerText = fileInput2.files.length + " file uploaded";
                        } else if (fileInput2.files.length == 1 && fileInput2.files[0] != '' && fileInput2.files[0].name == fName2  ) {
                            // const fileArray = [fInput.files[1]];
                            const dt = new DataTransfer();
                            // dt.items.add(fileArray[0]);
                            fileInput2.files = dt.files;
                            vN2.innerText = '';
                        }
                    }
                });
            }

        }
        //jangan lupo dibaekin jok
    });
}

// Time Value Setting

// const time = document.querySelectorAll('.time');

// function timeValueSet() {

//     $('.time').val("60 Menit");

//     //khusus Mozilla
//     for (let i = 0; i < time.length; i++) {
//         time[i].addEventListener('change', function() {
//             if (time[i].value == '') {
//                 $('.time').val("60 Menit"); 
//             }
//         });
        
//     }
// }

// $(document).ready(function() {
//     timeValueSet();
// });





const addQ = document.querySelector('.add-question');
const addQ2 = document.querySelector('.quiz-essay .add-question');
const del = document.querySelectorAll('.delete');

const quizContainer = document.querySelectorAll('.quiz-container');
const quizGroup = document.querySelectorAll('.quiz-group');
const btnGroup = document.querySelectorAll('.btn-group');
var i = 1; // ini yang dicari selamo ni

//Add Form Function (Quiz Pilgan)

if ( $('.add-question').length != '' ) {
    addQ.addEventListener('click', function() {
        //parent
        const qG = document.createElement('div')
        qG.setAttribute('class', 'quiz-group-next');
        //parent

        //child Quiz Group
        const question = document.createElement('span');
        question.setAttribute('class', 'question');
        
        //sub-child Question
        // var i = 1;
        i++;

        // var app = angular.module('myApp', []);
        // app.controller('myCtrl', function($scope) {

        //     $scope.count = 1;
        //     $scope.myFunction = function() {
        //         $scope.count++;
        //     }
        // });


        const number = document.createElement('span');
        number.setAttribute('class', 'number');
        number.innerText =  i + '.';

        const taQ = document.createElement('textarea');
        taQ.setAttribute('class', 'ta-section');
        taQ.setAttribute('name', 'pertanyaan[]');
        taQ.setAttribute('rows', '3');
        taQ.setAttribute('cols', '80');
        taQ.setAttribute('placeholder', 'Pertanyaan');

        question.append(number, taQ);
        //sub-child Question

        const label = document.createElement('h3');
        label.innerText = 'Pilihan';

        const cG1 = document.createElement('div');
        cG1.setAttribute('class', 'choice-group');

        //sub-child Choice Group 1
        const choice1 = document.createElement('span');
        choice1.setAttribute('class', 'choice');

        //sub-sub-child Choice 1
        const alpha1 = document.createElement('span');
        alpha1.setAttribute('class', 'alpha');
        alpha1.innerText = 'A.';

        const taC1 = document.createElement('textarea');
        taC1.setAttribute('class', 'ta-section');
        taC1.setAttribute('name', 'pilihan_1[]');
        taC1.setAttribute('placeholder', 'Pilihan 1');

        taC1.addEventListener('input', function() {
            if (taC1.value != '' ) {
                var scrollHeight = taC1.scrollHeight;
                var add = scrollHeight + 4;
                taC1.style.height = add + "px";
            } else if (taC1.value == '' ) {
                taC1.style.height = "28px";
            }
        });

        taC1.addEventListener('change', function() {
            rad1.value = taC1.value;
        });

        choice1.append(alpha1, taC1);
        //sub-sub-child Choice 1

        const true1 = document.createElement('span');
        true1.setAttribute('class', 'true');

        //sub-sub-child True 1
        const rad1 = document.createElement('input');
        rad1.setAttribute('type', 'checkbox');
        rad1.setAttribute('name', 'pilihan[]');
        rad1.setAttribute('value', '');

        true1.append(rad1);
        //sub-sub-child True 1
        
        cG1.append(choice1, true1);
        //sub child Choice Group 1

        const cG2 = document.createElement('div');
        cG2.setAttribute('class', 'choice-group');

        //sub-child Choice Group 2
        const choice2 = document.createElement('span');
        choice2.setAttribute('class', 'choice');

        //sub-sub-child Choice 2
        const alpha2 = document.createElement('span');
        alpha2.setAttribute('class', 'alpha');
        alpha2.innerText = 'B.';

        const taC2 = document.createElement('textarea');
        taC2.setAttribute('class', 'ta-section');
        taC2.setAttribute('name', 'pilihan_2[]');
        taC2.setAttribute('placeholder', 'Pilihan 2');

        taC2.addEventListener('input', function() {
            if (taC2.value != '' ) {
                var scrollHeight = taC2.scrollHeight;
                var add = scrollHeight + 4;
                taC2.style.height = add + "px";
            } else if (taC2.value == '' ) {
                taC2.style.height = "28px";
            }
        });

        taC2.addEventListener('change', function() {
            rad2.value = taC2.value;
        });


        choice2.append(alpha2, taC2);
        //sub-sub-child Choice 2

        const true2 = document.createElement('span');
        true2.setAttribute('class', 'true');

        //sub-sub-child True 2
        const rad2 = document.createElement('input');
        rad2.setAttribute('type', 'checkbox');
        rad2.setAttribute('name', 'pilihan[]');
        rad2.setAttribute('value', '');

        true2.append(rad2);
        //sub-sub-child True 2
        
        cG2.append(choice2, true2);
        //sub child Choice Group 2

        const cG3 = document.createElement('div');
        cG3.setAttribute('class', 'choice-group');

        //sub-child Choice Group 3
        const choice3 = document.createElement('span');
        choice3.setAttribute('class', 'choice');

        //sub-sub-child Choice 3
        const alpha3 = document.createElement('span');
        alpha3.setAttribute('class', 'alpha');
        alpha3.innerText = 'C.';

        const taC3 = document.createElement('textarea');
        taC3.setAttribute('class', 'ta-section');
        taC3.setAttribute('name', 'pilihan_3[]');
        taC3.setAttribute('placeholder', 'Pilihan 3');

        taC3.addEventListener('input', function() {
            if (taC3.value != '' ) {
                var scrollHeight = taC3.scrollHeight;
                var add = scrollHeight + 4;
                taC3.style.height = add + "px";
            } else if (taC3.value == '' ) {
                taC3.style.height = "28px";
            }
        });

        taC3.addEventListener('change', function() {
            rad3.value = taC3.value;
        });


        choice3.append(alpha3, taC3);
        //sub-sub-child Choice 3

        const true3 = document.createElement('span');
        true3.setAttribute('class', 'true');

        //sub-sub-child True 3
        const rad3 = document.createElement('input');
        rad3.setAttribute('type', 'checkbox');
        rad3.setAttribute('name', 'pilihan[]');
        rad3.setAttribute('value', '');

        true3.append(rad3);
        //sub-sub-child True 3
        
        cG3.append(choice3, true3);
        //sub child Choice Group 3

        const cG4 = document.createElement('div');
        cG4.setAttribute('class', 'choice-group');

        //sub-child Choice Group 4
        const choice4 = document.createElement('span');
        choice4.setAttribute('class', 'choice');

        //sub-sub-child Choice 4
        const alpha4 = document.createElement('span');
        alpha4.setAttribute('class', 'alpha');
        alpha4.innerText = 'D.';

        const taC4 = document.createElement('textarea');
        taC4.setAttribute('class', 'ta-section');
        taC4.setAttribute('name', 'pilihan_4[]');
        taC4.setAttribute('placeholder', 'Pilihan 4');

        taC4.addEventListener('input', function() {
            if (taC4.value != '' ) {
                var scrollHeight = taC4.scrollHeight;
                var add = scrollHeight + 4;
                taC4.style.height = add + "px";
            } else if (taC4.value == '' ) {
                taC4.style.height = "28px";
            }
        });

        taC4.addEventListener('change', function() {
            rad4.value = taC4.value;
        });


        choice4.append(alpha4, taC4);
        //sub-sub-child Choice 4

        const true4 = document.createElement('span');
        true4.setAttribute('class', 'true');

        //sub-sub-child True 4
        const rad4 = document.createElement('input');
        rad4.setAttribute('type', 'checkbox');
        rad4.setAttribute('name', 'pilihan[]');
        rad4.setAttribute('value', '');

        true4.append(rad4);
        //sub-sub-child True 1
        
        cG4.append(choice4, true4);
        //sub child Choice Group

        const point = document.createElement('span');
        point.setAttribute('class', 'point');

        //sub-child Point
        const iP = document.createElement('input');
        iP.setAttribute('class', 'input-section');
        iP.setAttribute('name', 'point[]');
        iP.setAttribute('type', 'text');
        iP.setAttribute('placeholder', 'Point');

        point.append(iP);
        //sub-child Point

        const dlt = document.createElement('span');
        dlt.setAttribute('class', 'delete-next');
        dlt.innerText = ' Hapus ';

        //sub-child Dlt
        const icon = document.createElement('i');
        icon.setAttribute('class', 'fa fa-trash');

        dlt.prepend(icon);
        //sub-child Dlt

        dlt.addEventListener('click', function() {
            quizContainer[0].removeChild(qG);
        });

        qG.append(question, label, cG1, cG2, cG3, cG4, point, dlt);
        //child Quiz Group

        quizContainer[0].insertBefore(qG, btnGroup[0]);
    });
}

//Add Form Function (Quiz Essay)

if ( $('.add-question').length != '' ) {
    addQ2.addEventListener('click', function() {
        //parent
        const qG2 = document.createElement('div');
        qG2.setAttribute('class', 'quiz-group-next');
        //parent

        //child Quiz Group 2
        const question2 = document.createElement('span');
        question2.setAttribute('class', 'question');

        //sub-child Question 2
        var i = 1;
        i++;

        const number2 = document.createElement('span');
        number2.setAttribute('class', 'number');
        number2.innerText =  i + '.';

        const taQ2 = document.createElement('textarea');
        taQ2.setAttribute('class', 'ta-section');
        taQ2.setAttribute('name', 'pertanyaan[]');
        taQ2.setAttribute('rows', '3');
        taQ2.setAttribute('cols', '80');
        taQ2.setAttribute('placeholder', 'Pertanyaan');

        question2.append(number2, taQ2);
        //sub-child Question 2

        const point2 = document.createElement('span');
        point2.setAttribute('class', 'point');

        //sub-child Point 2
        const iP2 = document.createElement('input');
        iP2.setAttribute('class', 'input-section');
        iP2.setAttribute('name', 'point[]');
        iP2.setAttribute('type', 'text');
        iP2.setAttribute('placeholder', 'Point');

        point2.append(iP2);
        //sub-child Point 2

        const dlt2 = document.createElement('span');
        dlt2.setAttribute('class', 'delete-next');
        dlt2.innerText = ' Hapus ';

        //sub-child Dlt 2
        const icon2 = document.createElement('i');
        icon2.setAttribute('class', 'fa fa-trash');

        dlt2.prepend(icon2);
        //sub-child Dlt 2

        dlt2.addEventListener('click', function() {
            quizContainer[1].removeChild(qG2);
        });

        qG2.append(question2, point2, dlt2);
        //child Quiz Group 2

        quizContainer[1].insertBefore(qG2, btnGroup[1])
    });
}

//Delete Form Function

if ( $('.delete').length != '' ) {
    for (let i = 0; i < del.length; i++) {
        del[i].addEventListener('click', function() {
            quizContainer[i].removeChild(quizGroup[i]);
        });
        
    }
}



//Pagination Form Function

const pg1 = document.querySelector('.pagination .pg1');
const pg2 = document.querySelector('.pagination .pg2');
const pg3 = document.querySelector('.pagination .pg3');
const pg4 = document.querySelector('.pagination .pg4');

const ipg1 = document.querySelector('.pagination .ipg1');
const ipg2 = document.querySelector('.pagination .ipg2');
const ipg3 = document.querySelector('.pagination .ipg3');
const ipg4 = document.querySelector('.pagination .ipg4');

const formInfo = document.querySelector('.form-information-section');
const formAssg = document.querySelector('.form-assignment-section');
const qPilgan = document.querySelector('.quiz-section:nth-child(3)');
const qEssay = document.querySelector('.quiz-section:nth-child(4)');

function pagination() {

    formAssg.style.display = 'none';
    qPilgan.style.display = 'none';
    qEssay.style.display = 'none';

    pg1.addEventListener('click', function() {
        
        formAssg.style.display = 'none';
        qPilgan.style.display = 'none';
        qEssay.style.display = 'none';
        formInfo.style.display = 'grid';
        pg2.classList.remove('active-links');
        pg3.classList.remove('active-links');
        pg4.classList.remove('active-links');
        pg1.classList.add('active-links');
    });

    pg2.addEventListener('click', function() {
        
        formInfo.style.display = 'none';
        qPilgan.style.display = 'none';
        qEssay.style.display = 'none';
        formAssg.style.display = 'grid';
        pg1.classList.remove('active-links');
        pg3.classList.remove('active-links');
        pg4.classList.remove('active-links');
        pg2.classList.add('active-links');
    });

    pg3.addEventListener('click', function() {
        
        formInfo.style.display = 'none';
        formAssg.style.display = 'none';
        qEssay.style.display = 'none';
        qPilgan.style.display = 'grid';
        pg1.classList.remove('active-links');
        pg2.classList.remove('active-links');
        pg4.classList.remove('active-links');
        pg3.classList.add('active-links');
    });

    pg4.addEventListener('click', function() {
        
        formInfo.style.display = 'none';
        formAssg.style.display = 'none';
        qPilgan.style.display = 'none';
        qEssay.style.display = 'grid';
        pg1.classList.remove('active-links');
        pg2.classList.remove('active-links');
        pg3.classList.remove('active-links');
        pg4.classList.add('active-links');
    });

}
pagination();




