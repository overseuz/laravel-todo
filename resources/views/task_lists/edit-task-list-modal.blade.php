<div class="modal fade edit-task-list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Редактировать список</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form action="{{ route('update.task_list') }}" method="POST" id="update-task-list-form">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="form-group">
                        <label for="">Название</label>
                        <input type="text" class="form-control" name="title" placeholder="Введите название">
                        <span class="text-danger error-text title_error"></span>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-block btn-success">Применить изменения</button>
                    </div>
                 </form>
            </div>
        </div>
    </div>
</div>