@extends('backend.app')

@section('title', 'Create Service')

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

                <li class="breadcrumb-item text-muted"> Services </li>
                <li class="breadcrumb-item text-muted"> Service Create </li>

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
                    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="input-style-1 mt-4">
                            <label for="title">Title:</label>
                            <input type="text" placeholder="Enter Title" id="title"
                                class="form-control @error('title') is-invalid @enderror" name="title"
                                value="{{ old('title') }}" />
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="input-style-1 col-lg-6 mt-4">
                                <label for="sub_description ">Sub Description :</label>
                                <textarea placeholder="Type here..." id="sub_description " name=" sub_description"
                                    rows="8" class="form-control @error(' sub_description ') is-invalid @enderror">
                                        {{ old(' sub_description ') }}
                                    </textarea>
                                @error(' sub_description ')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="input-style-1 col-lg-6 mt-4">
                                <label for="description"> Description :</label>
                                <textarea placeholder="Type here..." id="content" name="description"
                                    class="form-control @error('description') is-invalid @enderror">
                                        {{ old('description') }}
                                    </textarea>
                                @error(' description ')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-style-1 col-lg-6 mt-4">
                                <label for="icon">Icon:</label>
                                <input type="file" placeholder="Enter icon" id="icon"
                                    class="dropify form-control @error('icon') is-invalid @enderror" name="icon"
                                    data-default-file="{{ asset('backend/images/placeholder/image_placeholder.png') }}">
                                @error('icon')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="input-style-1 col-lg-6 mt-4">
                                <label for="image">Image:</label>
                                <input type="file" placeholder="Enter Image" id="image"
                                    class="dropify form-control @error('image') is-invalid @enderror" name="image"
                                    data-default-file="{{ asset('backend/images/placeholder/image_placeholder.png') }}">
                                @error('image')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-danger me-2">Cancel</a>
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
