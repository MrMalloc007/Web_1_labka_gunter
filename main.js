$(function (){ // зачекать эту функцию

    function isValidNum(num) {
        return !isNaN(parseFloat(num)) && isFinite(num);
    }

    let y;
    function validate_for_Y() {
        y = document.querySelector("div.tablevalue input[name = coordinata_Y]").value.replace(",", ".");
        if (y === "") {
            $("#infoinfo").after('<br class="remove"><p class="remove">Введите Y</p>');
            return false;
        }else if ( y <= -3 || y >= 5 ){
            $("#infoinfo").after('<br class="remove"><p class="remove">Выберите Y в кооректном диапазоне</p>');
            return false;
        }else if (!isValidNum(y)){
            $("#infoinfo").after('<br class="remove"><p class="remove">Введите число</p>');
            return false;
        }
        return true;
    }

    let r1,r2,r3,r4,r5;
    function validate_for_R(){
        r1 = document.querySelector('#myradio_1');
        r2 = document.querySelector('#myradio_2');
        r3 = document.querySelector('#myradio_3');
        r4 = document.querySelector('#myradio_4');
        r5 = document.querySelector('#myradio_5');
        if (r1.checked === false && r2.checked === false && r3.checked === false && r4.checked === false && r5.checked === false){
            $("#infoinfo").after('<br class="remove"><p class="remove">Ввыберите R </p>');
            return false;
        }else {
            return true;
        }
    }
        // document.querySelector('#myradio_1').checked = true;


    function main_validation(){
        $(".remove").remove();
        if (validate_for_Y() && validate_for_R()){
            $("#infoinfo").after('<br class="remove"><p class="remove">Complete</p>');
            return true;
        }
        return false;
    }

    $("#mainform").submit( function (event) {
        event.preventDefault();
        if (!main_validation()) return;
        $.ajax({
            url: 'action.php',
            method: 'post',
            dataType: 'json',
            data: $(this).serialize() + '&time=' + new Date().getTimezoneOffset(), // зачекать
            success: function (data) {
                $('.button').attr('disabled', false);
                newRow = '<tr>';
                newRow += '<td>' + data.coordinata_X + '</td>';
                newRow += '<td>' + data.coordinata_Y + '</td>';
                newRow += '<td>' + data.coordinata_R + '</td>';
                newRow += '<td>' + data.timeLol + '</td>';
                newRow += '<td>' + data.timeLong + '</td>';
                newRow += '<td>' + data.itog + '</td>';
                $('.table1table').append(newRow);
            }
        })
    });
})
