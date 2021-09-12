@extends('layouts.app')

@section('title', 'Списки задач')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Списки задач
                </div>
                <div class="card-body">
                    <table class="table table-hover table-condensed" id="task-lists-table">
                        <thead>
                            <th>#</th>
                            <th>Название</th>
                            <th>Дата создания</th>
                            <th></th>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Добавить список задач
                </div>
                <div class="card-body">
                    <form action="{{ route('add.task_list') }}" method="POST" id="add-task-list">
                        @csrf
                        <div class="form-group">
                            <label for="#title">Название списка</label>
                            <input class="form-control" id="title" name="title" type="text" placeholder="Введите название списка">
                            <span class="text-danger error-text title_error"></span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-success" type="submit">Сохранить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('/task_lists/edit-task-list-modal')

@endsection

@push('scripts')
<script>
    toastr.options.preventDuplicates = true;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(function() {
        // Создание списка задач
        $('#add-task-list').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    } else {
                        $(form)[0].reset();
                        $('#task-lists-table').DataTable().ajax.reload(null, false);
                        toastr.success(data.message);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                  if (jqXHR.status == 500) {
                      alert('Internal error: ' + jqXHR.responseText);
                  } else {
                      alert('Unexpected error.');
                  }
              }
            });
        });

        // Получить список задач
        $('#task-lists-table').DataTable({
            processing: true,
            info: true,
            ajax: "{{ route('get.task_lists') }}",
            pageLength: 5,
            aLengthMenu: [
                [5, 10, 25, 50, -1], 
                [5, 10, 25, 50, "All"]
            ],
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'title', name: 'title'},
                {data: 'created_at', name: 'created_at'},
                {data: 'actions', name: 'actions'}
            ],
            language: {
                url: "{{ asset('app/plugins/datatables/js/datatable_russian.json') }}"
            }
        });

        // Вывод модального окна для изменения списка задач
        $(document).on('click', '#edit-list-btn', function() {
            var list_id = $(this).data('id');
            $('.edit-task-list').find('form')[0].reset();
            $('.edit-task-list').find('span.error-text').text('');
            $.post("{{ route('get.task_list_details') }}", {list_id:list_id}, function(data) {
                $('.edit-task-list').find('input[name="id"]').val(data.details.id);
                $('.edit-task-list').find('input[name="title"]').val(data.details.title);
                $('.edit-task-list').modal('show');
            }, 'json');
        });

        // Обновить список задач
        $('#update-task-list-form').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $.ajax({
                url: $(form).attr('action'),
                method: $(form).attr('method'),
                data: new FormData(form),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function() {
                    $(form).find('span.error-text').text('');
                },
                success: function(data) {
                    if (data.status == 0) {
                        $.each(data.error, function(prefix, val) {
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    } else {
                        $('#task-lists-table').DataTable().ajax.reload(null, false);
                        $('.edit-task-list').modal('hide');
                        $('.edit-task-list').find('form')[0].reset();
                        toastr.success(data.message);
                    }
                }
            });
        });

        // Удалить список задач
        $(document).on('click', '#delete-list-btn', function() {
            var list_id = $(this).data('id');
            swal.fire({
                title: 'Вы действительно хотите удалить список задач?',
                showCancelButton: true,
                showCloseButton: true,
                cancelButtonText: 'Отмена',
                confirmButtonText: 'Да, удалить',
                cancelButtonColor: '#d33',
                confirmButtonColor: '#556ee6',
                width: 400,
                allowOutsideClick: false
            }).then(function(result) {
                if (result.value) {
                    $.post("{{ route('delete.task_list') }}", {list_id:list_id}, function(data) {
                        if (data.status == 1) {
                            $('#task-lists-table').DataTable().ajax.reload(null, false);
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message);
                        }
                    }, 'json');
                }
            });
        });
    });


</script>
@endpush