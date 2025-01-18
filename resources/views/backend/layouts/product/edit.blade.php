@extends('backend.app')

@section('title', 'Create Product')

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

                    <li class="breadcrumb-item text-muted"> Products </li>
                    <li class="breadcrumb-item text-muted"> Products Create </li>

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
                        <form method="POST" action="{{ route('admin.products.update', $product->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-8">
                                    <h2>Product Information</h2>
                                    <div class="row">
                                        <div class="input-style-1 col-lg-6 mt-4">
                                            <label for="title">Title:</label>
                                            <input type="text" placeholder="Enter Title" id="title"
                                                class="form-control @error('title') is-invalid @enderror" name="title"
                                                value="{{ $product->title ?? old('title') }}" />
                                            @error('title')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="input-style-1 col-lg-6 mt-4">
                                            <label for="category">Category:</label>
                                            <select name="product_category_id" id="category"
                                                class="form-control @error('product_category_id') is-invalid @enderror">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        @if ($product->product_category_id == $category->id) selected @endif>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_category_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-style-1 col-lg-4 mt-4">
                                            <label for="price">Price:</label>
                                            <input type="text" placeholder="Enter Price" id="price"
                                                class="form-control @error('price') is-invalid @enderror" name="price"
                                                value="{{ $product->price ?? old('price') }}" />
                                            @error('price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="input-style-1 col-lg-4 mt-4">
                                            <label for="discount_price">Discount Price:</label>
                                            <input type="text" placeholder="Enter Discount Price" id="discount_price"
                                                class="form-control @error('discount_price') is-invalid @enderror"
                                                name="discount_price"
                                                value="{{ $product->discount_price ?? old('discount_price') }}" />
                                            @error('discount_price')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="input-style-1 col-lg-4 mt-4">
                                            <label for="quantity">Quantity:</label>
                                            <input type="number" min="1" placeholder="Enter Quantity" id="quantity"
                                                class="form-control @error('quantity') is-invalid @enderror" name="quantity"
                                                value="{{ $product->quantity ?? old('quantity') }}" />
                                            @error('quantity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="input-style-1 col-lg-6 mt-4 ">
                                            <label for="about">Product About :</label>
                                            <textarea placeholder="Type here..." id="about " name="about" rows="8"
                                                class="form-control @error('about') is-invalid @enderror">
                                                {{ $product->about ?? old('about') }}
                                            </textarea>
                                            @error('about')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="input-style-1 col-lg-6 mt-4">
                                            <label for="description">Description :</label>
                                            <textarea placeholder="Type here..." id="content" name="description"
                                                class="form-control @error('description') is-invalid @enderror">
                                                {{ $product->description ?? old('description') }}
                                            </textarea>
                                            @error(' description ')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row gallery-images mb-4">
                                        <div class="flex items-center justify-between gap-5 mb-2">
                                            <label for="gallery_images" class="form-lable">Product Images</label>
                                            <button type="button" id="add-gallery-image" class="btn btn-danger btn-sm"
                                                style="float: right">
                                                Add image
                                            </button>
                                        </div>
                                        <div class="row" id="gallery-images-section">
                                            @if (!empty($product->images) && count($product->images) > 0)
                                                @foreach ($product->images as $index => $image)
                                                    <div class="col-lg-4 flex justify-center items-center border single-gallery-image position-relative mb-4 mr-2"
                                                        style="" id="single-image">
                                                        <!-- Delete Button -->
                                                        <div class="position-absolute top-0 end-0 px-2 py-1 rounded-full">
                                                            <button type="button"
                                                                onclick="showDeleteConfirm({{ $image->id }}, this, 'image', '{{ $image->images }}')"
                                                                class="p-1 bg-danger text-white position-absolute"
                                                                style="top: 0; right: -2px; z-index: 999; border-radius: 50%; border: 0;">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 24 24" fill="none"
                                                                    stroke="currentColor" stroke-linecap="round"
                                                                    stroke-linejoin="round" width="24" height="24"
                                                                    stroke-width="2">
                                                                    <path d="M18 6l-12 12"></path>
                                                                    <path d="M6 6l12 12"></path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <!-- Gallery Image -->
                                                        <img class="object-cover" style="width: 100%; height: 100%;"
                                                            src="{{ asset($image->images) }}" alt="gallery image">
                                                    </div>
                                                @endforeach
                                            @endif
                                            <div class="col-lg-4 single-gallery-image mb-2">
                                                <input type="file" name="gallery_images[0]" id="gallery_0"
                                                    class="dropify @error('gallery_images.0') is-invalid @enderror"
                                                    data-default-file="{{ asset('backend/images/placeholder/image_placeholder1.png') }}"
                                                    data-height="300" />
                                                @if ($errors->has('gallery_images.0'))
                                                    <div class="text-danger">{{ $message }}</div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="card" style="border: 1px solid #ebebeb">
                                        <div class="card-header">
                                            <h4 class="card-title">Product Benefits</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="">
                                                <table class="table table-bordered" id="dynamic_field">
                                                    <div class="card-header" style="padding: 0px;">
                                                        <h5 class="card-title">Product Benefits (Click Add For More
                                                            Benefits)</h5>
                                                    </div>

                                                    <!-- Existing Benefits Preloaded -->
                                                    @foreach ($product->benefits as $key => $benefit)
                                                        <tr>
                                                            <td id="single-benefit">
                                                                <input type="text"
                                                                    value="{{ $benefit->title }}"
                                                                    class="form-control name_list"
                                                                    placeholder="Product Benefits" readonly />
                                                            </td>
                                                            <td>
                                                                <button type="button" name="remove"
                                                                    onclick="showDeleteConfirm({{ $benefit->id }}, this, 'benefit', '{{ $benefit->title }}')"
                                                                    class="btn btn-danger">
                                                                    X
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach

                                                    <!-- Add New Benefit -->
                                                    <tr>
                                                        <td>
                                                            <input type="text" name="product_benefits[]"
                                                                class="form-control name_list"
                                                                placeholder="Product Benefits" />
                                                        </td>
                                                        <td>
                                                            <button type="button" name="add" id="add"
                                                                class="btn btn-success">Add +</button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.products.index') }}" class="btn btn-danger me-2">Cancel</a>
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


        //add gallery image
        let imageSectionCount = 0
        $('#add-gallery-image').click(function() {
            imageSectionCount++
            $('#gallery-images-section').append(`<div class="col-lg-4 position-relative single-gallery-image mb-2">
             <button type="button" class="remove-gallery-section p-1 bg-danger text-white position-absolute" style="top: 0; right: -2px; z-index: 999; border-radius: 50%; border: 0">
                 <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" width="24" height="24" stroke-width="2">
                    <path d="M18 6l-12 12"></path>
                    <path d="M6 6l12 12"></path>
                </svg>
             </button>
             <input type="file" name="gallery_images[${imageSectionCount}]" id="gallery_${imageSectionCount}"
                    class="dropify form-control @error('gallery_images.${imageSectionCount}') is-invalid @enderror" data-default-file="{{ asset('backend/images/placeholder/image_placeholder1.png') }}" data-height="300"/>
                @if ($errors->has('gallery_images.${imageSectionCount}'))
                    <div class="text-danger">{{ $message }}</div>
                @endif
         </div>`)
            $('.dropify').dropify();
        })

        //remove gallery image
        $(document).on('click', '.remove-gallery-section', function() {
            $(this).parent().remove()
        })

        $(document).ready(function() {
            var postURL = "<?php echo url('addmore'); ?>";
            var i = 1;

            $('#add').click(function() {
                i++;
                $('#dynamic_field').append('<tr id="row' + i +
                    '" class="dynamic-added"><td><input type="text" name="product_benefits[]" class="form-control name_list" placeholder="Add More Product Benefits" /></td><td><button type="button" name="remove" id="' +
                    i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
            });
            $(document).on('click', '.btn_remove', function() {
                var button_id = $(this).attr("id");
                $('#row' + button_id + '').remove();
            })
        });
    </script>
    <script>
        function showDeleteConfirm(id, element, type = 'benefit', path = null) {
            event.preventDefault(); // Prevent default event behavior

            Swal.fire({
                title: 'Are you sure you want to delete this record?',
                text: 'If you delete this, it will be gone forever.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    if (type === 'benefit') {
                        deleteBenefit(id, element);
                    } else if (type === 'image') {
                        deleteImage(id, element, path);
                    }
                }
            });
        }

        function deleteImage(id, element, path) {
            $.ajax({
                url: "{{ route('admin.products.image.delete', ':id') }}".replace(':id', id),
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                data: {
                    path
                },
                success: function(response) {
                    if (response.success) {
                        $(element).closest('#single-image').remove();
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
                    toastr.error(errorMessage);
                }
            });
        }

        // Event listener to remove a gallery image
        $(document).on('click', '.remove-gallery-section', function() {
            $(this).parent('.single-gallery-image').remove();
        });

        function deleteBenefit(id, element, path) {
            $.ajax({
                url: "{{ route('admin.products.benefit.delete', ':id') }}".replace(':id', id),
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                },
                data: {
                    path
                },
                success: function(response) {
                    if (response.success) {
                        $(element).closest('tr').remove();
                        toastr.success(response.message);
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function(xhr) {
                    let errorMessage = xhr.responseJSON?.message || 'Something went wrong. Please try again.';
                    toastr.error(errorMessage);
                }
            });
        }
    </script>
@endpush
