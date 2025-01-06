@extends('backend.app')

@section('title', 'Edit Team')

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar" id="kt_toolbar">
        <div class=" container-fluid  d-flex flex-stack flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <!--begin::Title-->
                <h1 class="text-dark fw-bold my-1 fs-2">
                    Dashboard <small class="text-muted fs-6 fw-normal ms-1"></small>
                </h1>
                <!--end::Title-->

                <!--begin::Breadcrumb-->
                <ul class="breadcrumb fw-semibold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('admin.dashboard') }}" class="text-muted text-hover-primary">
                            Home </a>
                    </li>

                    <li class="breadcrumb-item text-muted"> Teams </li>
                    <li class="breadcrumb-item text-muted"> Edit & Update Team </li>

                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Toolbar-->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card-style mb-4">
                    <div class="card card-body">
                        <form method="POST" action="{{ route('admin.teams.update', $team->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="input-style-1 col-lg-6 mt-4">
                                    <label for="name">Name:</label>
                                    <input type="text" placeholder="Enter name" id="name"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ $team->name ?? old('name') }}" />
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-style-1 col-lg-6 mt-4">
                                    <label for="specialty">Specialty:</label>
                                    <input type="text" placeholder="Enter specialty" id="specialty"
                                        class="form-control @error('specialty') is-invalid @enderror" name="specialty"
                                        value="{{ $team->specialty ?? old('specialty') }}" />
                                    @error('specialty')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="row">
                                <div class="input-style-1 col-lg-4 mt-4">
                                    <label for="experience">Experience:</label>
                                    <input type="text" placeholder="Enter experience" id="experience"
                                        class="form-control @error('experience') is-invalid @enderror" name="experience"
                                        value="{{ $team->experience ?? old('experience') }}" />
                                    @error('experience')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-style-1 col-lg-4 mt-4">
                                    <label for="consult_duration">Consult Duration:</label>
                                    <input type="text" placeholder="Enter consult duration" id="consult_duration"
                                        class="form-control @error('consult_duration') is-invalid @enderror" name="consult_duration"
                                        value="{{ $team->consult_duration ?? old('consult_duration') }}" />
                                    @error('consult_duration')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-style-1 col-lg-4 mt-4">
                                    <label for="total_fees">Total Fees:</label>
                                    <input type="number" min="1" placeholder="Enter total fees" id="total_fees"
                                        class="form-control @error('total_fees') is-invalid @enderror" name="total_fees"
                                        value="{{ $team->total_fees ?? old('total_fees') }}" />
                                    @error('total_fees')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                            <div class="row">
                                <div class="input-style-1 col-lg-6 mt-4">
                                    <label for="phone_one">Phone Number:</label>
                                    <input type="text" placeholder="Enter Phone" id="phone_one"
                                        class="form-control @error('phone_one') is-invalid @enderror" name="phone_one"
                                        value="{{ $team->phone_one ?? old('phone_one') }}" />
                                    @error('phone_one')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-style-1 col-lg-6 mt-4">
                                    <label for="phone_two">Secend Phone Number:</label>
                                    <input type="text" placeholder="Enter Secend Phone" id="phone_two"
                                        class="form-control @error('phone_two') is-invalid @enderror" name="phone_two"
                                        value="{{ $team->phone_two ?? old('phone_two') }}" />
                                    @error('phone_two')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>

                            <div class="input-style-1 mt-4">
                                <label for="location">Location:</label>
                                <textarea name="location" class="form-control @error('location') is-invalid @enderror" id="location" rows="2" placeholder="Enter location">{{ $team->location ?? old('location') }}</textarea>
                                @error('location')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="input-style-1 col-lg-6 mt-4">
                                    <label for="specializes ">Specializes :</label>
                                    <textarea placeholder="Type here..." id="specializes " name=" specializes" rows="8"
                                        class="form-control @error(' specializes ') is-invalid @enderror">
                                        {{ $team->specializes ?? old(' specializes ') }}
                                    </textarea>
                                    @error(' specializes ')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="input-style-1 col-lg-6 mt-4">
                                    <label for="about"> About :</label>
                                    <textarea placeholder="Type here..." id="content" name="about"
                                        class="form-control @error('about') is-invalid @enderror">
                                        {{  $team->about ?? old('about') }}
                                    </textarea>
                                    @error(' about ')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="input-style-1 mt-4">
                                <label for="image_url">Photo:</label>
                                <input type="file" placeholder="Enter Image" id="image_url"
                                    class="dropify form-control @error('image_url') is-invalid @enderror" name="image_url" data-default-file="{{ asset( $team->image_url ?? 'backend/images/placeholder/image_placeholder.png') }}">
                                @error('image_url')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.teams.index') }}" class="btn btn-danger me-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
