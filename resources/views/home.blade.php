@extends('common.layout')

@section('title', 'Todo App')

@section('main')
<div class="add-task">
    <form id="addTask" action="{{ route('task.add') }}" method="post">
        @csrf
        <input type="text" name="task" id="task" placeholder="Enter Task">
        <button type="submit">Add Task</button>
        <button class="all-task" type="button" onclick="loadAllTasks()">All Tasks</button>
    </form>
</div>


<div class="table-wrapper">
    <table id="tasks" class="display">
        <thead>
            <tr>
                <th width: 100px;>#</th>
                <th>Task</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@section('script')
<script>
    function loadTasks() {
        $('#tasks').DataTable().destroy();
        $('#tasks').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: '{{ route("taskList.ajax", ["active"]) }}',
                dataType: 'json',
                type: 'get',
                dataSrc: (res) => {
                    console.log(res);
                    return res.data;
                }
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'task'
                },
                {
                    data: 'status'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        if (data.status == 'Pending') {
                            
                            return `<button class="btn btn-success btn-sm complete" onclick="completeTask(${ data.id })" title="Complete Task">
                                <span class="material-symbols-outlined">task_alt</span>
                            </button>
                            <button class="btn btn-danger delete btn-sm" onclick="deleteTask(${ data.id })" title="Delete Task">
                                <span class="material-symbols-outlined">delete</span>
                            </button>`

                        } else {
                            return `<button class="btn btn-danger delete btn-sm" onclick="deleteTask(${ data.id })" title="Delete Task">
                                <span class="material-symbols-outlined">delete</span>
                            </button>`
                        }
                    }
                },
            ],
            columnDefs: [{
                "orderable": false,
                "targets": [2, 3]
            }],
        });
    }

    function loadAllTasks() {
        $('#tasks').DataTable().destroy();
        $('#tasks').DataTable({
            processing: true,
            serverSide: true,
            searching: false,
            ajax: {
                url: '{{ route("taskList.ajax", ["all"]) }}',
                dataType: 'json',
                type: 'get',
                dataSrc: (res) => {
                    console.log(res);
                    return res.data;
                }
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'task'
                },
                {
                    data: 'status'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        if (data.status == 'Pending') {
                            
                            return `<button class="btn btn-success btn-sm complete" onclick="completeTask(${ data.id })" title="Complete Task">
                                <span class="material-symbols-outlined">task_alt</span>
                            </button>
                            <button class="btn btn-danger delete btn-sm" onclick="deleteTask(${ data.id })" title="Delete Task">
                                <span class="material-symbols-outlined">delete</span>
                            </button>`

                        } else {
                            return `<button class="btn btn-danger delete btn-sm" onclick="deleteTask(${ data.id })" title="Delete Task">
                                <span class="material-symbols-outlined">delete</span>
                            </button>`
                        }
                    }
                },
            ],
            columnDefs: [{
                "orderable": false,
                "targets": [2, 3]
            }],
        });
    }

    function completeTask(taskId) {
        var url = "{{ route('task.complete', ['_id_']) }}";
        var url = url.replace('_id_', taskId);

        $.ajax({
            type: "get",
            url: url,
            success: function(response) {
                console.log(response);

                if (response.status) {
                    $('#alertMessage').append(`<x-alert class="success" message="${response.message}"></x-alert>`);

                    loadTasks();

                } else {
                    $('#alertMessage').append(`<x-alert class="danger" message="${response.message}"></x-alert>`);
                }

                $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                    $(".alert").slideUp(500);
                    $(".alert").remove();
                });
            },
            error: function(error) {
                // console.log(error);
                $('#alertMessage').append(`<x-alert class="danger" message="${error.message}"></x-alert>`);

                $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                    $(".alert").slideUp(500);
                    $(".alert").remove();
                });
            }
        });
    }

    function deleteTask(taskId) {
        var conf = confirm("Are you sure to delete this Task?");

        if (!conf) {
            return;
        }

        var url = "{{ route('task.delete', ['_id_']) }}";
        var url = url.replace('_id_', taskId);

        $.ajax({
            type: "get",
            url: url,
            success: function(response) {
                console.log(response);

                if (response.status) {
                    $('#alertMessage').append(`<x-alert class="success" message="${response.message}"></x-alert>`);

                    loadTasks();

                } else {
                    $('#alertMessage').append(`<x-alert class="danger" message="${response.message}"></x-alert>`);
                }

                $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                    $(".alert").slideUp(500);
                    $(".alert").remove();
                });
            },
            error: function(error) {
                // console.log(error);
                $('#alertMessage').append(`<x-alert class="danger" message="${error.message}"></x-alert>`);

                $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                    $(".alert").slideUp(500);
                    $(".alert").remove();
                });
            }
        });
    }

    $('document').ready(() => {
        loadTasks();
    });

    $('#addTask').on('submit', (e) => {
        e.preventDefault();

        const formData = new FormData(e.target).entries();
        const formObj = Object.fromEntries(formData);

        $.ajax({
            type: "post",
            url: "{{ route('task.add') }}",
            data: formObj,
            success: function(response) {
                console.log(response);

                if (response.status) {
                    $('#alertMessage').append(`<x-alert class="success" message="${response.message}"></x-alert>`);

                    loadTasks();

                } else {
                    $('#alertMessage').append(`<x-alert class="danger" message="${response.message}"></x-alert>`);
                }

                $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                    $(".alert").slideUp(500);
                    $(".alert").remove();
                });
            },
            error: function(error) {
                // console.log(error);
                $('#alertMessage').append(`<x-alert class="danger" message="${error.message}"></x-alert>`);

                $(".alert").fadeTo(2000, 500).slideUp(500, function() {
                    $(".alert").slideUp(500);
                    $(".alert").remove();
                });
            }
        });

    });
</script>
@endsection