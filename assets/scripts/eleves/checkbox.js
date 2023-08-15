
$(document).ready(function () {
    isActifFunction();
    function isActifFunction() {
        $(document).on('change', '#eleves_isActif', function () {
            let checkboxActif = document.getElementById('eleves_isActif');
            let checkboxAdmis = document.getElementById('eleves_isAdmis');
            if (checkboxActif.checked && !checkboxAdmis.checked) {
                checkboxActif.checked = false;
                alert("Vous ne pouvez pas être Actif sans être Admis");
            }
        });

        $(document).on('change', '#eleves_isAdmis', function () {
            let checkboxActif = document.getElementById('eleves_isActif');
            let checkboxAdmis = document.getElementById('eleves_isAdmis');
            if (!checkboxAdmis.checked && checkboxActif.checked) {
                checkboxActif.checked = false;
                alert("Vous devez être Admis pour être Actif");
            }
        });
    }

    ControleACtifFunction();
    function ControleACtifFunction() {

        $(document).ready(function () {
            let checkboxActif = document.getElementById('eleves_isActif');
            let checkboxAdmis = document.getElementById('eleves_isAdmis');
            if (checkboxActif.checked && !checkboxAdmis.checked) {
                checkboxActif.checked = false;
                alert("Vous ne pouvez pas être Actif sans être Admis");
            }
            if (!checkboxAdmis.checked && checkboxActif.checked) {
                checkboxActif.checked = false;
                alert("Vous devez être Admis pour être Actif");
            }

        });
    }

});
