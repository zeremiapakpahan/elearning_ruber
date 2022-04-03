// Hamburger Menu Effect (Landing Page)
const menuToggle = document.querySelector('.menu-toggle input'); //mengambil .menu-toggle input
const nav = document.querySelector('nav ul'); //mengambil nav ul

if ( $('.menu-toggle input').length != '' ) {
    //jika menuToggle di klik, maka akan meenjalankan fungsi di bawah ini:
    menuToggle.addEventListener('click', function() {
        nav.classList.toggle('slide');
    });
}

// Slide Form Effect (Register and Login)
// const guru = document.getElementById("guru");
// const siswa = document.getElementById("siswa");
const btn = document.getElementById("btn");
const guruBtn = document.getElementById("guru-btn");
const siswaBtn = document.getElementById("siswa-btn");
const mediaQueryNB = window.matchMedia("(max-width: 1335px)");
const mediaQueryTB = window.matchMedia("(max-width: 1024px)");
const mediaQueryTS = window.matchMedia("(max-width: 768px)");
const mediaQueryMS = window.matchMedia("(min-width: 280px) and (max-width: 576px)");

// if ( $('#siswa-btn').length != '' ) {
//     siswaBtn.addEventListener('click', function() {
//         guru.style.left = "-455px";
//         siswa.style.left = "55px";
//         btn.style.left = "120px";
//         guruBtn.style.color = "#262626";
//         siswaBtn.style.color = "#f0f4f7";
//     }); 
// } 

// if ($('#guru-btn').length != '') {
//     guruBtn.addEventListener('click', function() {
//         guru.style.left = "55px";
//         siswa.style.left = "455px";
//         btn.style.left = "0";
//         guruBtn.style.color = "#f0f4f7";
//         siswaBtn.style.color = "#262626";
//     }); 
// }


// Change Form Register

function changeForm() {
    if (window.location.href.indexOf('register/guru') != -1) {
        btn.style.left = "0";
        guruBtn.style.color = "#f0f4f7";
        siswaBtn.style.color = "#262626";
    } else if (window.location.href.indexOf('register/siswa') != -1) {
        btn.style.left = "120px";
        guruBtn.style.color = "#262626";
        siswaBtn.style.color = "#f0f4f7";
    }
}
changeForm();

// Change Form Login

function changeForm2() {
    if (window.location.href.indexOf('login/guru') != -1) {
        btn.style.left = "0";
        guruBtn.style.color = "#f0f4f7";
        siswaBtn.style.color = "#262626";
    } else if (window.location.href.indexOf('login/siswa') != -1) {
        btn.style.left = "120px";
        guruBtn.style.color = "#262626";
        siswaBtn.style.color = "#f0f4f7";
    }
}
changeForm2();

document.addEventListener('DOMContentLoaded', resize);

function resize() {
    if (mediaQueryNB.matches) {
        if ( $('#siswa-btn').length != '' ) {
            siswaBtn.addEventListener('click', function() {
                guru.style.left = "-34vw";
                siswa.style.left = "4.3vw";
                btn.style.left = "50%";
                guruBtn.style.color = "#262626";
                siswaBtn.style.color = "#f0f4f7";
            }); 
        } 

        if ($('#guru-btn').length != '') {
            guruBtn.addEventListener('click', function() {
                guru.style.left = "4.3vw";
                siswa.style.left = "34vw";
                btn.style.left = "0";
                guruBtn.style.color = "#f0f4f7";
                siswaBtn.style.color = "#262626";
            }); 
        }

    }
    
    if (mediaQueryTB.matches) {
        if ( $('#siswa-btn').length != '' ) {
            siswaBtn.addEventListener('click', function() {
                guru.style.left = "-100vw";
                siswa.style.left = "12.6vw";
                btn.style.left = "50%";
                guruBtn.style.color = "#262626";
                siswaBtn.style.color = "#f0f4f7";
            }); 
        } 

        if ($('#guru-btn').length != '') {
            guruBtn.addEventListener('click', function() {
                guru.style.left = "12.6vw";
                siswa.style.left = "100vw";
                btn.style.left = "0";
                guruBtn.style.color = "#f0f4f7";
                siswaBtn.style.color = "#262626";
            }); 
        }
    }
}


// Sidebar Effect + Untuk Ukuran Mobile

const hideBtn = document.querySelector("#hide-btn");
const sidebar = document.querySelector(".sidebar");
const shadowBg = document.querySelector(".shadow-bg");

if ( $('#hide-btn').length != '' ) {
    hideBtn.addEventListener('click', function() {
        sidebar.classList.toggle("active");
        shadowBg.classList.toggle("cover");
    });
}

if ( $('.shadow-bg').length != '' ) {
    shadowBg.addEventListener('click', function() {
        sidebar.classList.remove("active");
        shadowBg.classList.remove("cover");
    });
}

// Profil Image Upload Effect

const profilImage = document.getElementById('profil-img');
const fileUpload = document.getElementById('file-upload');
const form = document.getElementById('form');

if ( $('#file-upload').length != '' ) {
    fileUpload.addEventListener('change', function() {
        // const choosedFile = this.files[0];
    
        // if (choosedFile) {
    
        //     const reader = new FileReader();
    
        //     reader.addEventListener('load', function() {
        //         profilImage.setAttribute('src', reader.result);
        //     });
    
        //     reader.readAsDataURL(choosedFile);
        // }

        form.submit();
    
    });
}

// Profil Image Upload Effect (Versi Top Bar)

const topProfilImage = document.getElementById('top-profil-img');
const topFileUpload = document.getElementById('top-file-upload');
const topForm = document.getElementById('top-form');

if ( $('#top-file-upload').length != '' ) {
    topFileUpload.addEventListener('change', function() {
        const topChoosedFile = this.files[0];
    
        if (topChoosedFile) {
    
            const topReader = new FileReader();
    
            topReader.addEventListener('load', function() {
                topProfilImage.setAttribute('src', topReader.result);
            });
    
            topReader.readAsDataURL(topChoosedFile);
        }

        topForm.submit();
    
    });
}

// Edit Profil Effect

const editLink = document.querySelector('#edit-link');
const formEditContainer = document.querySelector('.form-edit-container');
const bio = document.querySelector('.bio');

if ( $('#edit-link').length != '' ) {
    editLink.addEventListener('click', function() {
        bio.classList.toggle("hide");
        formEditContainer.classList.toggle("exist");
    });
}

// Edit Profil Effect (Versi Top Bar)

const topEditLink = document.querySelector('#top-edit-link');
const topFormEditContainer = document.querySelector('.top-form-edit-container');
const topBio = document.querySelector('.top-bio');

if ( $('#top-edit-link').length != '' ) {
    topEditLink.addEventListener('click', function() {
        topBio.classList.toggle("hide");
        topFormEditContainer.classList.toggle("exist");
    });
}

// Dropdown Notification Effect

const notif = document.querySelector('.top-notif-heading span');
const dropdown = document.querySelector('.dropdown-container');

if ( $('.top-notif-heading span').length != '' ) {
    notif.addEventListener('click', function() {
        dropdown.classList.toggle("display-block");
    });
}


// Split dan SubString Nama
function str1() {

    if ( $('.nama-lengkap').length != '' ) {
        var nama = document.querySelector('.nama-lengkap');
        var array = nama.innerText.split(" ");
        // nama.innerHTML = array[0] + " " + array[1];
        var namaDepan = array[0].toString();
        var namaBelakang = array[1].toString();
    
        if (namaDepan.length > 13) {
            var sbstrNd = namaDepan.substring(0, 13) + "...";
        } else {
            var sbstrNd = namaDepan;
        }
    
        if (namaBelakang.length > 13) {
            var sbstrNb = namaBelakang.substring(0, 13) + "...";
        } else {
            var sbstrNb = namaBelakang;
        }
    
        nama.innerText = sbstrNd + " " + sbstrNb;
    }

    if ( $('.bio span:nth-child(2)').length != '' ) {
        var email = document.querySelector('.bio span:nth-child(2)');
        var emailArray = email.innerText.split("@");
        var emailName = emailArray[0].toString();
        var emailDomain = emailArray[1].toString();

        if (emailName.length > 21) {
            var sbstrEn = emailName.substring(0, 21) + "..."
        } else {
            var sbstrEn = emailName;
        }

        email.innerText = sbstrEn + "@" + emailDomain;
    }

}
str1();

function str2() {

    if ( $('.nama').length != '' ) {
        
        var nama = document.querySelector('.nama');
        var array = nama.innerText.split(" ");
        // nama.innerHTML = array[0] + " " + array[1];
        var namaDepan = array[0].toString();
        var namaBelakang = array[1].toString();

        if (namaDepan.length > 13) {
            var sbstrNd = namaDepan.substring(0, 13) + "...";
        } else {
            var sbstrNd = namaDepan;
        }

        if (namaBelakang.length > 13) {
            var sbstrNb = namaBelakang.substring(0, 13) + "...";
        } else {
            var sbstrNb = namaBelakang;
        }

        nama.innerText = sbstrNd + " " + sbstrNb;
    }

    if ( $(".top-bio span:nth-child(2)").length != '' ) {

        var email = document.querySelector('.top-bio span:nth-child(2)');
        var emailArray = email.innerText.split("@");
        var emailName = emailArray[0].toString();
        var emailDomain = emailArray[1].toString();

        if (emailName.length > 10 ) {
            var sbstrEn = emailName.substring(0, 10) + "...";
        } else {
            var sbstrEn = emailName;
        }

        email.innerText = sbstrEn + "@" + emailDomain;
    }
}
str2();


// Touchscreen Hover Effect


const menu = document.querySelectorAll('.sidebar ul li');

for (let i = 0; i < menu.length; i++) {
    
    menu[i].addEventListener("touchstart", function() {
        menu[i].classList.toggle("hover");
    });
}


// Deskripsi Kelas Style

const deskripsi = document.querySelectorAll('#deskripsi');
const styleElement = document.querySelectorAll('.kelas-desk span:nth-child(2) div');

function colorChange() {  
    if ( $('#deskripsi').length != '' ) {

        for (let i = 0; i < deskripsi.length; i++) {
            
            if (deskripsi[i].innerText == "TIK" || deskripsi[i].innerText == "SBK" || deskripsi[i].innerText == "English") {
                styleElement[i].style.setProperty('--backgroundColor', '#4bb2f7');
                deskripsi[i].style.backgroundColor = "#4bb2f7";
            } else if (deskripsi[i].innerText == "Mandarin" || deskripsi[i].innerText == "PJOK" || deskripsi[i].innerText == "Musik") {
                styleElement[i].style.setProperty('--backgroundColor', '#f74b76');
                deskripsi[i].style.backgroundColor = "#f74b76";
            }  else if (deskripsi[i].innerText == "Matematika" || deskripsi[i].innerText == "Agama" || deskripsi[i].innerText == "Tipografi" || deskripsi[i].innerText == "Bahasa Indonesia") {
                styleElement[i].style.setProperty('--backgroundColor', '#7e3ffc');
                deskripsi[i].style.backgroundColor = "#7e3ffc";
            } else if (deskripsi[i].innerText == "IPA" || deskripsi[i].innerText == "PKN" || deskripsi[i].innerText == "IPS") {
                styleElement[i].style.setProperty('--backgroundColor', '#b24bf7');
                deskripsi[i].style.backgroundColor = "#b24bf7";
            }

        }
        // belom selesai
        
    }
}
colorChange();

// Reset Form After Page Refresh

function resetForms() {
    for (let i = 0; i < document.forms.length; i++) {
        document.forms[i].reset();
    }
}

$(document).ready(function() {
    resetForms();
});


// Change Position Form Group (Admin Login)

const fGroup = document.querySelector('.form-group');

function changePos() {
    if (window.location.href.indexOf('admin/login') != -1) {
        fGroup.style.top = "100px";
    }
}
changePos();

