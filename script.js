document.addEventListener('DOMContentLoaded', function () {
    const gamintojasSelect = document.getElementById('gamintojas');
    const ekranoIstrizaineSelect = document.getElementById('ekrano_istrizaine');
    const procesoriusSelect = document.getElementById('procesorius');
    const vaizdoPloksteSelect = document.getElementById('vaizdo_plokste');
    const ramSelect = document.getElementById('ram');
    const hddSelect = document.getElementById('hdd');
    const rezoliucijaSelect = document.getElementById('rezoliucija');
    const lieciamasEkranasSelect = document.getElementById('lieciamas_ekranas');
    const pavadinimasSelect = document.getElementById('pavadinimas');
    const aprasymasSelect = document.getElementById('aprasymas');
    const kainaNuoInput = document.getElementById('kaina_nuo');
    const kainaIkiInput = document.getElementById('kaina_iki');
    const submitBtn = document.getElementById('submit_btn');
    let timeoutId;

    gamintojasSelect.addEventListener('change', function () {
        submitBtn.click();
    });

    ekranoIstrizaineSelect.addEventListener('change', function () {
        submitBtn.click();
    });

    procesoriusSelect.addEventListener('change', function () {
        submitBtn.click();
    });

    vaizdoPloksteSelect.addEventListener('change', function () {
        submitBtn.click();
    });

    ramSelect.addEventListener('change', function () {
        submitBtn.click();
    });

    hddSelect.addEventListener('change', function () {
        submitBtn.click();
    });

    rezoliucijaSelect.addEventListener('change', function () {
        submitBtn.click();
    });

    lieciamasEkranasSelect.addEventListener('change', function () {
        submitBtn.click();
    });

    pavadinimasSelect.addEventListener('change', function () {
        submitBtn.click();
    });

    aprasymasSelect.addEventListener('change', function () {
        submitBtn.click();
    });

    kainaNuoInput.addEventListener('input', function () {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function () {
            submitBtn.click();
        }, 500); // Wait for 500ms before submitting the form
    });

    kainaIkiInput.addEventListener('input', function () {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(function () {
            submitBtn.click();
        }, 500); // Wait for 500ms before submitting the form
    });
});