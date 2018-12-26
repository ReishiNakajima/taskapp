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
    taskCard.children().find('.editBtn').attr('data-role', 'save');
    taskCard.children().find('.editBtn i').removeClass('fa-edit');
    taskCard.children().find('.editBtn i').addClass('fa-save');
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
    taskCard.children().find('.editBtn').attr('data-role', 'edit');
    taskCard.children().find('.editBtn i').removeClass('fa-save');
    taskCard.children().find('.editBtn i').addClass('fa-edit');
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
$('#sortable').delegate('.modeChangeBtn', 'click', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-taskid');
    if ($(this).attr('data-role') == 'save') {
        $('#collapseOne' + id).collapse('hide');
        $('#taskCard' + id).children().find('.head-2 button').attr('data-role', 'edit');
        $('#taskCard' + id).children().find('.head-2 button i').attr('style', 'transform:rotateX(0deg)');
        $('#taskCard' + id).children().find('.head-2 button a').text('open');
    } else {
        $('#collapseOne' + id).collapse('show');
        $('#taskCard' + id).children().find('.head-2 button').attr('data-role', 'save');
        $('#taskCard' + id).children().find('.head-2 button i').attr('style', 'transform:rotateX(180deg)');
        $('#taskCard' + id).children().find('.head-2 button a').text('close');
    }

});
//ダブルクリック対策必要

$('#sortable').delegate('.editBtn', 'click', function (e) {
    e.preventDefault();
    var id = $(this).attr('data-taskid');
    if ($(this).attr('data-role') == 'save') {
        updateTask(id);
        forViewCrad('taskCard' + id);
    } else {
        forEditCard('taskCard' + id);
    }
});


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
        .done(function (data) {
            $('#nameView' + id).text($('#name' + id).val());
            $('#deadlineView' + id).text($('#date' + id).val() + ' ' + $('#time' + id).val());
            $('#noteView' + id).text($('#note' + id).val());
        })
        .fail(function (data) {
            console.log(data);
        });
}
$('#sortable').delegate('.doneBtn', 'touchstart click', function (e) {
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
        .done(function (data) {
            $('#taskCard' + id).addClass('deletedCard');
            $('#taskCard' + id).fadeOut(1000);
            updateProgress();
        })
        .fail(function (data) {
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
        .done(function (data) {
            $('#tr' + id).hide();
        })
        .fail(function (data) {
            console.log(data);
        });
};

function unDeleteTask(id) {
    $.ajax({
        type: "POST",
        url: "ajaxTaskCrud.php?q=delete",
        data: {
            id: id,
            deleteFlag: 0
        }
    })
        .done(function (data) {
            $('#tr' + id).hide();
        })
        .fail(function (data) {
            console.log(data);
        });
};

$('#doneModal').delegate('.unDoneBtn', 'click', function () {
    unDoneTask($(this).attr('data-taskid'));
});

$('#trashModal').delegate('.unDoneBtn', 'click', function () {
    unDeleteTask($(this).attr('data-taskid'));
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
        .done(function (data) {
            console.log(data);
            $('#doneModal').children().find('tbody').empty();
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var trHTML = '<tr id="tr' + element.id + '">' +
                    '<td scope="row">' +
                    '<button class="btn btn-link unDoneBtn" type="button" data-taskid="' +
                    element.id + '">' +
                    '<i class="fas fa-undo-alt"></i>back' +
                    '</button></td><td><h5>' +
                    element.name +
                    '</h5></td><td><button class="btn btn-link deleteBtn" type="button" data-taskid="' +
                    element.id + '">' +
                    '<i class="fas fa-eraser"></i>delete</button></td></tr>';
                $('#doneModal').children().find('tbody').append(trHTML);
            }
            $('#doneModal').modal('show');
        })
        .fail(function (data) {
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
        .done((data) => {
            updateTaskCard();
            updateProgress();
            $('#newName').val('');
            $('#newDate').val('');
            $('#newTime').val('');
            $('#newNote').val('');
            $('#newTaskCard').hide();
            updateProgress();
            console.log(data);

        })
        .fail(function (data) {
            console.log(data);
        });

});
$('.cancelBtn').click(function (e) {
    e.preventDefault();
    $('#newTaskCard').hide();
    $('#newName').val('');
    $('#newDate').val('');
    $('#newTime').val('');
    $('#newNote').val('');
    $('#newTaskCard').hide();

});

function deleteTask(id, type) {
    $.ajax({
        type: "POST",
        url: "ajaxTaskCrud.php?q=delete",
        data: {
            id: id,
            deleteFlag: 1
        }
    })
        .done(function (data) {
            if (type === 'modal') {
                $('#tr' + id).hide();
            } else if (type === 'card') {
                $('#taskCard' + id).addClass('deletedCard');
                $('#taskCard' + id).fadeOut(1000);
                updateProgress();
            }
        })
        .fail(function (data) {
            console.log(data);
        });
};

$('#doneModal').delegate('.deleteBtn', 'click', function () {
    deleteTask($(this).attr('data-taskid'), 'modal');
});

$('#sortable').delegate('.deleteBtn', 'click', function () {
    deleteTask($(this).attr('data-taskid'), 'card');
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
        .done(function (data) {
            console.log(data);
            $('#trashModal').children().find('tbody').empty();
            for (let index = 0; index < data.length; index++) {
                const element = data[index];
                var trHTML = '<tr id="tr' + element.id + '">' +
                    '<td scope="row"><button class="btn btn-link unDoneBtn" type="button" data-taskid="' +
                    element.id + '">' +
                    '<i class="fas fa-undo-alt"></i>back' +
                    '</button></td><td><h5>' +
                    element.name +
                    '</h5></td><td><button class="btn btn-link finalDeleteBtn" type="button" data-taskid="' +
                    element.id + '">' +
                    '<i class="fas fa-ban"></i>delete' +
                    '</button></td></tr>';
                $('#trashModal').children().find('tbody').append(trHTML);
            }
            $('#trashModal').modal('show');
        })
        .fail(function (data) {
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
        .done(function (data) {
            $('#tr' + id).hide();
        })
        .fail(function (data) {
            console.log(data);
        });
};

$('#trashModal').delegate('.finalDeleteBtn', 'click', function () {
    finalDeleteTask($(this).attr('data-taskid'));
});

function updateTaskCard() {
    $.ajax({
        type: "POST",
        url: "ajaxGetHtml.php?q=undoneTaskCardList"
        ,
        //リクエストが完了するまで実行される
        beforeSend: function () {
            $('.loading').removeClass('hide');
        }

    })
        .done((data) => {
            $('.loading').addClass('hide');
            $('#sortable').empty();
            $('#sortable').append(data);
        })
        .fail(function (data) {
            console.log(data);
        });
};

function filterTaskCardBydeadline(date) {
    $.ajax({
        type: "POST",
        url: "ajaxGetHtml.php?q=undoneTaskCardList",
        data: {
            byDeadline: date
        }
    })
        .done(function (data) {
            $('#sortable').empty();
            $('#sortable').append(data);
        })
        .fail(function (data) {
            console.log(data);
        });
};

$('.nav-item').click(function (e) {
    e.preventDefault();
    $('.nav-item').removeClass('active');
    $(this).addClass('active');
    switch ($(this).children('.nav-link').attr('href')) {
        case '#all':
            updateTaskCard();
            break;
        case '#today':
            filterTaskCardBydeadline('today');
            break;
        case '#this_week':
            filterTaskCardBydeadline('this_week');
            break;
        default:
            break;
    }
    window.location.href = $(this).children('.nav-link').attr('href');

});

$('div').on('hide.bs.modal', function (e) {
    updateTaskCard();
    updateProgress();
});

$('#viewMode').on('touchstart click', function (e) {
    if ($(this).prop("checked")) {
        $('.card-body').parents('div.collapse').collapse('show');
        $('.head-2 button').attr('data-role', 'save');
        $('.head-2 button i').attr('style', 'transform:rotateX(180deg)');
        $('.head-2 button a').text('close');
    } else {
        $('.collapse').collapse('hide');
        $('.head-2 button').attr('data-role', 'edit');
        $('.head-2 button i').attr('style', 'transform:rotateX(0deg)');
        $('.head-2 button a').text('open');
    }
});

function updateProgress() {
    $.ajax({
        type: "POST",
        url: "ajaxGetHtml.php?q=progressBar"
    })
        .done(function (data) {
            $('#progressArea').empty();
            $('#progressArea').append(data);
        })
        .fail(function (data) {
            console.log(data);
        });
};

