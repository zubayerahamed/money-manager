<x-setup-layout pageTitle="{{ __('setup.page.database.title') }}">
    <form action="{{ route('setup.save-database') }}" method="POST">
        @csrf

        <div class="card-body">
            <h6 class="text-center">{{ __('setup.page.heading.database') }}</h6>

            <p class="text-center">{!! __('setup.page.sub-heading.database') !!}</p>

            <div class="row">

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="db_host" class="form-label">{{ __('setup.label.db_host') }}</label>
                        <input type="text" name="db_host" id="db_host" required class="form-control" placeholder="localhost" value="{{ old('db_host') ?: env('DB_HOST', 'localhost') }}">
                        @error('db_host')
                            <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="db_port" class="form-label">{{ __('setup.label.db_port') }}</label>
                        <input type="number" name="db_port" id="db_port" required class="form-control" placeholder="3306" value="{{ old('db_port') ?: env('DB_PORT', 3306) }}">
                        @error('db_port')
                            <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="mb-3">
                <label for="db_name" class="form-label">{{ __('setup.label.db_name') }}</label>
                <input type="text" name="db_name" id="db_name" required class="form-control" value="{{ old('db_name') ?: env('DB_DATABASE') }}">
                @error('db_name')
                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="db_user" class="form-label">{{ __('setup.label.db_user') }}</label>
                <input type="text" name="db_user" id="db_user" required class="form-control" value="{{ old('db_user') ?: env('DB_USERNAME') }}">
                @error('db_user')
                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="db_password" class="form-label">{{ __('setup.label.db_password') }}</label>
                <input type="password" name="db_password" id="db_password" class="form-control" value="{{ old('db_password') ?: env('DB_PASSWORD') }}">
                @error('db_password')
                    <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            @if (session('data_present', false))
                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="overwrite_data" value="0">
                        <input type="checkbox" class="form-check-input" id="overwrite_data" checked />
                        <label class="form-check-label text-danger" for="overwrite_data">{{ __('setup.label.data_present') }}</label>
                    </div>
                </div>
            @endif

            <p class="small text-muted mt-3 mb-0 text-center">{{ __('setup.label.special-note') }}</p>
        </div>

        <div class="card-footer">
            <a href="{{ route('setup.requirements') }}" class="btn btn-sm btn-light"><i class="ph-arrow-fat-lines-left me-2"></i> {{ __('setup.btn.previous') }}</a>
            <button type="submit" class="btn btn-success float-end">
                @if ($errors->any())
                    {{ __('setup.btn.try-again') }}
                @else
                    {{ __('setup.btn.configure-db') }}
                @endif
            </button>
        </div>

    </form>
</x-setup-layout>
