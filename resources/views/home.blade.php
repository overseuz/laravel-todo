@extends('layouts.app')

@section('title', 'Главная')

@section('task-lists')
    <li class="nav-header text-uppercase">Мои списки задач</li>
    <li class="nav-item">
        @foreach ($task_lists as $index => $list)
            <a class="nav-link-task-lists nav-link @if ($index == 0) active @endif task-list-menu" role="button" target="{{ $list->id }}">
                <i class="far fa-circle nav-icon"></i>
                <p>{{ $list->title }}</p>
            </a>
        @endforeach
    </li>
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if (!$task_lists->isEmpty())
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4 col-lg-2">
                            <button class="btn btn-primary mb-3 w-100" id="add-task">Создать задачу</button>
                        </div>
                        <div class="col-12 col-sm-6 col-md-8 col-lg-10">
                            <input class="form-control" type="text" id="tags-search" placeholder="Поиск задач по тегам">
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        Задачи
                    </div>
                    <div class="card-body">
                        <table class="table table-hover table-condensed" id="tasks-table">
                            <thead>
                                <th>#</th>
                                <th>Название</th>
                                <th>Изображение</th>
                                <th>Дата создания</th>
                                <th>Теги</th>
                                <th></th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="alert alert-danger" role="alert">
                    У вас не создано ни одного списка задач!
                </div>
                <a class="btn btn-primary" href="{{ route('task_lists.index') }}">Создать список задач</a>
            @endif
        </div>
    </div>
</div>

@include('/tasks/add-task-modal')
@include('/tasks/edit-task-modal')

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
            // Перебор задач взависимости от выбранного списка задач
            $('.task-list-menu').click(function() {
                var list_id = $(this).attr('target');
                $('.task-list-menu').removeClass('active');
                $(this).addClass('active');
                $('#tasks-table').DataTable().ajax.url("/get_tasks/"+list_id).load();
            });

            // Показать модальное окно для добавления задачи
            $(document).on('click', '#add-task', function() {
                var task_list_id = $('.nav-link-task-lists.active').attr('target');
                $('#add-task-form').find('input[name="task_list_id"]').val(task_list_id);
                $('.custom-file-label').text('Выбрать файл');
                $('.add-task').modal('show');
                $('.image-preview').attr('src', '');
                $('.add-task').find('input[data-role="tagsinput"]').tagsinput('removeAll');
            });

            // Вывод модального окна для изменения задачи
            $(document).on('click', '#edit-task-btn', function() {
                var task_id = $(this).data('id');
                $('.update-task').find('form')[0].reset();
                $('.update-task').find('span.error-text').text('');
                $('.update-task').find('.image-preview').attr('src', '');
                $('.update-task').find('input[data-role="tagsinput"]').tagsinput('removeAll');
                $.post("{{ route('get.task_details') }}", {task_id:task_id}, function(data) {
                    $('.update-task').find('input[name="id"]').val(data.details.id);
                    $('.update-task').find('input[name="title"]').val(data.details.title);
                    
                    if (data.tags != '') {
                        $('.update-task').find('input[data-role="tagsinput"]').tagsinput('add', data.tags);
                    }

                    if (data.details.image != '') {
                        $('.custom-file-label').text(data.details.image);
                        $('.update-task').find('.image-preview').attr('src', '/images/'+data.details.image);
                    } else {
                        $('.custom-file-label').text('Выбрать файл');
                    }
                    
                    $('.update-task').modal('show');
                }, 'json');
            });

            // Добавить задачу
            $('#add-task-form').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                $.ajax({
                    url: "{{ route('add.task') }}",
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
                            $('#tasks-table').DataTable().ajax.reload(null, false);
                            $('.add-task').modal('hide');
                            $('.add-task').find('form')[0].reset();
                            toastr.success(data.message);
                        }
                    }
                });
            });

            // Получить список задач
            var table = $('#tasks-table').DataTable({
                processing: true,
                info: true,
                ajax: "/get_tasks/"+$('.nav-link-task-lists.active').attr('target'),
                pageLength: 5,
                aLengthMenu: [
                    [5, 10, 25, 50, -1], 
                    [5, 10, 25, 50, "All"]
                ],
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'title', name: 'title'},
                    {data: 'file', name: 'file'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'tags', name: 'tags'},
                    {data: 'actions', name: 'actions'}
                ],
                language: {
                    url: "{{ asset('app/plugins/datatables/js/datatable_russian.json') }}"
                }
            });

            $('#tags-search').on('keyup', function() {
                table.columns(4).search(this.value).draw();
            });

            // Обновить задачу
            $('#update-task-form').on('submit', function(e) {
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
                            $('#tasks-table').DataTable().ajax.reload(null, false);
                            $('.update-task').modal('hide');
                            $('.update-task').find('form')[0].reset();
                            toastr.success(data.message);
                        }
                    },
                });
            });

            // Удалить список задач
            $(document).on('click', '#delete-task-btn', function() {
                var task_id = $(this).data('id');
                swal.fire({
                    title: 'Вы действительно хотите удалить задачу?',
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
                        $.post("{{ route('delete.task') }}", {task_id:task_id}, function(data) {
                            if (data.status == 1) {
                                $('#tasks-table').DataTable().ajax.reload(null, false);
                                toastr.success(data.message);
                            } else {
                                toastr.error(data.message);
                            }
                        }, 'json');
                    }
                });
            });

            // Превью картинки
            $(document).on('change', '.image-picker', function() {
                if (this.files && this.files[0]) {
                    var filename = this.files[0].name;
                    $('.custom-file-label').text(filename);
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('.image-preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });

            // Открытие изображения в новом окне
            $(document).on('click', '.image-preview', function(){
                var src = $(this).attr('src');
                let w = window.open('about:blank');
                let image = new Image();
                image.src = src;
                w.document.write(image.outerHTML);
            });
        });
    </script>
@endpush