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


// Show Submission File Name Function

const fnContainer = document.querySelectorAll('.submission-file div span');

function substrName() {
    for (let i = 0; i < fnContainer.length; i++) {
        var filePath = fnContainer[i].innerText;
        var pathArray = filePath.split('/');
        var fName = pathArray[2].toString();
        
        fnContainer[i].innerText = fName;
    }
}
substrName();


if (window.location.href.indexOf('guru/kelas/index') || window.location.href.indexOf('siswa/kelas/index') != -1) {
    
    // Sort The Post in Index Kelas Guru

    // ini yang aku cari wkwk

    // function comparator(a, b) {
    //     if (a.dataset.datetime < b.dataset.datetime)
    //         return -1;
    //     if (a.dataset.datetime > b.dataset.datetime)
    //         return 1;
    //     return 0;
    // }
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

    sorted.forEach( e => document.querySelector('.post-container').prepend(e)

    );

}

if (window.location.href.indexOf('guru/kelas/penugasan') || window.location.href.indexOf('guru/kelas/quiz-pilgan') || window.location.href.indexOf('guru/kelas/quiz-essay') != -1) {
    
    // Sort The Post in Index Kelas Guru

    // ini yang aku cari wkwk

    // function comparator(a, b) {
    //     if (a.dataset.datetime_sm < b.dataset.datetime_sm)
    //         return -1;
    //     if (a.dataset.datetime_sm > b.dataset.datetime_sm)
    //         return 1;
    //     return 0;
    // }
    function comparator(a, b) {
        if (new Date(a.dataset.datetime_sm) < new Date(b.dataset.datetime_sm))
            return -1;
        if (new Date(a.dataset.datetime_sm) > new Date(b.dataset.datetime_sm))
            return 1;
        return 0;
    }

    var datetimes = document.querySelectorAll('[data-datetime_sm]');
    var dtArray = Array.from(datetimes);

    let sorted = dtArray.sort(comparator);

    sorted.forEach( e => document.querySelector('.submission-section').append(e)

    );

}
