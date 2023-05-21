<x-layout pageTitle="{{ __('profile.page.title') }}">
    <!-- Content -->
    <div class="content">
        <div class="row">
            <div class="col-xl-12">

                <div class="row">
                    <!-- Profile Photo Section -->
                    <div class="col-lg-4">

                        <div class="card">
                            <div class="sidebar-section-body text-center" style="padding: 20px;">

                                <div class="card-img-actions d-inline-block mb-3">
                                    <img class="img-fluid rounded-circle" src="{{ auth()->user()->avatar }}" width="150" height="150" alt="">
                                    <div class="card-img-actions-overlay card-img rounded-circle">
                                        <input type="file" name="image" class="form-control avatar-image" id="avatar" accept="image/*">
                                        <a href="{{ route('profile.avatar') }}" class="btn btn-outline-white btn-icon rounded-pill avatar-upload" id="avatar-upload">
                                            <i class="ph-pencil"></i>
                                        </a>
                                    </div>
                                </div>

                                <h6 class="mb-0">{{ $user->name }}</h6>

                            </div>
                        </div>

                    </div>
                    <!-- ./Profile Photo Section -->

                    <!-- Profile Info Section -->
                    <div class="col-lg-8">

                        <!-- Update Profile -->
                        <div class="card">

                            <div class="card-header d-flex align-items-center">
                                <h5 class="mb-0">{{ __('profile.section1.title') }}</h5>
                            </div>

                            <div class="card-body border-top">
                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-3">
                                        <label class="form-label" for="name">{{ __('profile.label.name') }}</label>
                                        <div class="form-group">
                                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                            @error('name')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label" for="currency">{{ __('profile.label.currency') }}</label>
                                        <div class="form-group">
                                            <select id="currency" data-placeholder="Select a Currency..." name="currency" id="currency" class="form-control select2" required>
                                                <option>--Select currency--</option>
                                                @foreach (getAllCurrency() as $key => $val)
                                                    <option value="{{ $key }}" {{ old('currency', $user->currency) == $key ? 'selected' : '' }}>{{ $val }}</option>
                                                @endforeach
                                            </select>
                                            @error('currency')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">{{ __('common.btn.submit') }}<i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- ./Update Profile -->

                        <!-- Update Password -->
                        <div class="card">

                            <div class="card-header d-flex align-items-center">
                                <h5 class="mb-0">{{ __('profile.section2.title') }}</h5>
                            </div>

                            <div class="card-body border-top">
                                <form action="{{ route('profile.password') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="row mb-3">
                                        <label class="form-label" for="password">{{ __('profile.label.password') }}</label>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" class="form-control" required>
                                            @error('password')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label class="form-label" for="password_confirmation">{{ __('profile.label.password_confirmation') }}</label>
                                        <div class="form-group">
                                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                            @error('password_confirmation')
                                                <div class="form-text text-danger"><i class="ph-x-circle me-1"></i>{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">{{ __('common.btn.submit') }}<i class="ph-paper-plane-tilt ms-2"></i></button>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <!-- ./Update Password -->

                    </div>
                    <!-- ./Profile Info Section -->
                </div>

            </div>
        </div>
    </div>
    <!-- ./Content -->
</x-layout>
