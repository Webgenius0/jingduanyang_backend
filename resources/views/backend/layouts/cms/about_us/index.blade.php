@extends('backend.app')

@section('title', 'Cms || About Us Page')

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
                    <li class="breadcrumb-item text-muted"> About Us Page </li>

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
                        <form method="POST" action="{{ route('cms.about_us.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="input-style-1 mt-4">
                                <label for="title">Title:</label>
                                <input type="text" placeholder="Enter Title" id="title"
                                    class="form-control @error('title') is-invalid @enderror" name="title"
                                    value="{{ $about_us->title ?? old('title') }}" />
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1 mt-4">
                                <label for="description"> Description :</label>
                                <textarea placeholder="Type here..." id="content" name="description"
                                    class="form-control @error('description') is-invalid @enderror">
                                        {{ $about_us->description ?? old('description') }}
                                    </textarea>
                                @error(' description ')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-style-1 mt-4">
                                <label for="image_url">Image:</label>
                                <input type="file" placeholder="Enter Image" id="image_url"
                                    class="dropify form-control @error('image') is-invalid @enderror" name="image_url"
                                    data-default-file="{{ asset($about_us->image_url ?? 'backend/images/placeholder/image_placeholder.png') }}">
                                @error('image_url')
                                    <span class="text-danger" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-danger me-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Add Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Category Add Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body" id="create-category">
                    <form id="create-form">
                        @csrf
                        <div class="input-style-1 mb-4">
                            <label for="name">Category Name:</label>
                            <input type="text" placeholder="Enter Category name" id="name"
                                class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" />

                            <span id="create-category-error" class="text-danger"></span>

                        </div>

                        <button type="submit" class="btn btn-primary float-end">Save</button>
                    </form>

                </div>
            </div>

        </div>
    </div>

    {{-- Edit Modal --}}
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Category Edit Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="edit-category">
                    <form id="edit-form">
                        @csrf
                        <div class="input-style-1 mb-4">
                            <label for="edit_name">Category Name:</label>
                            <input type="text" placeholder="Enter Category name" id="edit_name"
                                class="form-control @error('name') is-invalid @enderror" name="name" />
                            <span id="edit-name-error" class="text-danger"></span>
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Save</button>
                    </form>
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
