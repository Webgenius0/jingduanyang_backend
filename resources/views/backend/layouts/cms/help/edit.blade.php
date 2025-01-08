@extends('backend.app')

@section('title', 'Cms || Help Section')

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

                    <li class="breadcrumb-item text-muted"> Cma </li>
                    <li class="breadcrumb-item text-muted"> Help Section Item Edit </li>

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
                <div class="card p-5">
                    <div class="card-style mb-30">
                        <h4 class="mb-4">Help Section Item Edit</h4>
                        <form method="POST" action="{{ route('item.update',$cms->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="input-style-1 mt-4">
                                <label for="title">Title:</label>
                                <input type="text" placeholder="Enter Title" id="title"
                                    class="form-control @error('title') is-invalid @enderror" name="title"
                                    value="{{ $cms->title ?? old('title') }}" />
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1 mt-4">
                                <label for="image_url">Icon:</label>
                                <input type="file" placeholder="Enter Image" id="image_url"
                                    class="dropify form-control @error('image') is-invalid @enderror" name="image_url"
                                    data-default-file="{{ asset($cms->image_url ?? 'backend/images/placeholder/image_placeholder.png') }}">
                                @error('image_url')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('cms.home.help_section.index') }}" class="btn btn-danger me-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection

@push('script')
    
@endpush
