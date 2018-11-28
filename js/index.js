$(function () {
    $("#sortable").sortable({
        handle: ".sortArea",
    });
    $(".sortArea").disableSelection();
});

$('.datepicker').pickadate({
    format: 'yyyy/mm/dd'
});

$('.timepicker').pickatime({
    format: 'HH:i',
});

function forEditCard(taskCardId) {
    var taskCard = $('#' + taskCardId);
    taskCard.addClass('editable');
    taskCard.children().find('.head-2 button').attr('data-role', 'save');
    taskCard.children().find('.head-2 button i').removeClass('fa-edit');
    taskCard.children().find('.head-2 button i').addClass('fa-save');
    taskCard.children().find('.head-2 button a').text('save');
    taskCard.children().find('.head-3 h5').hide();
    taskCard.children().find('.head-4 i').hide();
    taskCard.children().find('.head-4 a').hide();
    taskCard.children().find('.head-5 button').hide();
    taskCard.children().find('.card-text').hide();
    taskCard.children().find('.head-3 input').show();
    taskCard.children().find('.head-4 input').show();
    taskCard.children().find('.head-5 input').show();
    taskCard.children().find('.card-body textarea').show();
}

function forViewCrad(taskCardId) {
    var taskCard = $('#' + taskCardId);
    taskCard.removeClass('editable');
    taskCard.children().find('.head-2 button').attr('data-role', 'edit');
    taskCard.children().find('.head-2 button i').removeClass('fa-save');
    taskCard.children().find('.head-2 button i').addClass('fa-edit');
    taskCard.children().find('.head-2 button a').text('edit');
    taskCard.children().find('.head-3 h5').show();
    taskCard.children().find('.head-4 i').show();
    taskCard.children().find('.head-4 a').show();
    taskCard.children().find('.head-5 button').show();
    taskCard.children().find('.card-text').show();
    taskCard.children().find('.head-3 input').hide();
    taskCard.children().find('.head-4 input').hide();
    taskCard.children().find('.head-5 input').hide();
    taskCard.children().find('.card-body textarea').hide();
}

// ボタン押下時に発火
$('.modeChangeBtn').on('touchstart click', function (e) {
    e.preventDefault();
    var id = $(this).parents('.card').attr('id');
    if ($(this).attr('data-role') == 'save') {
        updateTask($(this).attr('data-taskid'));
        forViewCrad(id);
    } else {
        forEditCard(id);
    }
});
//ダブルクリック対策必要

function updateTask(id) {
    $.ajax({
        type: "POST",
        url: "ajaxTaskCrud.php?q=updateInfo",
        data: {
            id: id,
            name: $('#name' + id).val(),
            date: $('#date' + id).val(),
            time: $('#time' + id).val(),
            note: $('#note' + id).val()
        }
    })
        .done((data) => {
            $('#nameView' + id).text($('#name' + id).val());
            $('#deadlineView' + id).text($('#date' + id).val() + ' ' + $('#time' + id).val());
            $('#noteView' + id).text($('#note' + id).val());
        })
        .fail((data) => {
            console.log(data);
        });
}

$('.doneBtn').on('touchstart click', function (e) {
    e.preventDefault();
    doneTask($(this).attr('data-taskid'));
});

function doneTask(id) {
    $.ajax({
        type: "POST",
        url: "ajaxTaskCrud.php?q=updateStatus",
        data: {
            id: id,
            doneFlag: 1
        }
    })
        .done((data) => {
            $('#taskCard' + id).css('position', 'fixed');
            $('#taskCard' + id).css('bottom', '3%');
            $(this).hide();
            setTimeout(() => {
                $('#taskCard' + id).addClass('deletedCard');
                $('#taskCard' + id).fadeOut(1000);
            }, 500);
            $('#doneBox').addClass('purupuru');
            setTimeout(() => {
                $('#doneBox').removeClass('purupuru');
            }, 1800);
        })
        .fail((data) => {
            console.log(data);
        });
}

$('#newBtn').on('touchstart click', function (e) {
    e.preventDefault();
    $('#newTaskCard').fadeIn(500);
});

function unDoneTask(id) {
    $.ajax({
        type: "POST",
        url: "ajaxTaskCrud.php?q=updateStatus",
        data: {
            id: id,
            doneFlag: 0
        }
    })
        .done((data) => {
            $('#tr' + id).hide();
        })
        .fail((data) => {
            console.log(data);
        });
};

$('#doneModal').delegate('.unDoneBtn', 'click', function () {
    unDoneTask($(this).attr('data-taskid'));
});

$('#doneBox').on('touchstart click', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "ajaxTaskCrud.php?q=getTaskList",
        data: {
            deleteFlag: 0,
            doneFlag: 1,
            userId: 2
        }
    })
        .done((data) => {
            console.log(data);
            $('#doneModal').children().find('tbody').empty();
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var trHTML = '<tr id="tr' + element.id + '">' +
                    '<td scope="row">' +
                    '<button class="btn btn-link unDoneBtn" type="button" data-taskid="' +
                    element.id + '">' +
                    '<i class="fas fa-check"></i>back' +
                    '</button></td><td><h5>' +
                    element.name +
                    '</h5></td><td><button class="btn btn-link deleteBtn" type="button" data-taskid="' +
                    element.id + '">' +
                    '<i class="fas fa-check"></i>delete</button></td></tr>';
                $('#doneModal').children().find('tbody').append(trHTML);
            }
            $('#doneModal').modal('show');
        })
        .fail((data) => {
            console.log(data);
        });

});

$('.createBtn').on('touchstart click', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "ajaxTaskCrud.php?q=create",
        data: {
            name: $('#newName').val(),
            date: $('#newDate').val(),
            time: $('#newTime').val(),
            note: $('#newNote').val(),
            userId: 2
        }
    })
        .done((data) => {
            $('#newTaskCard').hide();
            console.log(data);

        })
        .fail((data) => {
            console.log(data);
        });

});

function deleteTask(id) {
    $.ajax({
        type: "POST",
        url: "ajaxTaskCrud.php?q=delete",
        data: {
            id: id
        }
    })
        .done((data) => {
            $('#tr' + id).hide();
        })
        .fail((data) => {
            console.log(data);
        });
};

$('#doneModal').delegate('.deleteBtn', 'click', function () {
    deleteTask($(this).attr('data-taskid'));
});

$('#trashBtn').on('touchstart click', function (e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "ajaxTaskCrud.php?q=getTaskList",
        data: {
            deleteFlag: 1,
            userId: 2
        }
    })
        .done((data) => {
            console.log(data);
            $('#trashModal').children().find('tbody').empty();
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var trHTML = '<tr id="tr' + element.id + '">' +
                    '<td scope="row">' +
                    '<button class="btn btn-link finalDeleteBtn" type="button" data-taskid="' +
                    element.id + '">' +
                    '<i class="fas fa-check"></i>back' +
                    '</button></td><td><h5>' +
                    element.name +
                    '</h5></td></tr>';
                $('#trashModal').children().find('tbody').append(trHTML);
            }
            $('#trashModal').modal('show');
        })
        .fail((data) => {
            console.log(data);
        });

});

function finalDeleteTask(id) {
    $.ajax({
        type: "POST",
        url: "ajaxTaskCrud.php?q=finalDelete",
        data: {
            id: id
        }
    })
        .done((data) => {
            $('#tr' + id).hide();
        })
        .fail((data) => {
            console.log(data);
        });
};

$('#trashModal').delegate('.finalDeleteBtn', 'click', function () {
    finalDeleteTask($(this).attr('data-taskid'));
});