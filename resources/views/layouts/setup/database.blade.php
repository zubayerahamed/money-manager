<input type="hidden" name="success-status" value="{{ $success }}">
<a href="{{ $prevUrl }}" class="prev-url"></a>

<div class="mb-3">
    <label for="db_host" class="form-label">Database Host</label>
    <input type="text" name="db_host" id="db_host" required class="form-control" placeholder="localhost" value="{{ env('DB_HOST', 'localhost') }}">
</div>

<div class="mb-3">
    <label for="db_port" class="form-label">Database Port</label>
    <input type="number" name="db_port" id="db_port" required class="form-control" placeholder="3306" value="{{ env('DB_PORT', 3306) }}">
</div>

<div class="mb-3">
    <label for="db_name" class="form-label">Database Name</label>
    <input type="text" name="db_name" id="db_name" required class="form-control" value="{{ env('DB_DATABASE') }}">
</div>

<div class="mb-3">
    <label for="db_user" class="form-label">Database User</label>
    <input type="text" name="db_user" id="db_user" required class="form-control" value="{{  env('DB_USERNAME') }}">
</div>

<div class="mb-3">
    <label for="db_password" class="form-label">Database Password</label>
    <input type="password" name="db_password" id="db_password" class="form-control" value="{{  env('DB_PASSWORD') }}">
</div>

@if (session('data_present', false))
    <div class="mb-3">
        <div class="form-check">
            <input type="hidden" name="overwrite_data" value="0">
            <input type="checkbox" class="form-check-input" id="overwrite_data" checked/>
            <label class="form-check-label text-danger" for="overwrite_data">
                I confirm that all data should be deleted and overwritten with a new blog database
            </label>
        </div>
    </div>
@endif