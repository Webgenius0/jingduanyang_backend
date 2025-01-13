@extends('backend.app')

@section('title', 'Edit Quizzes Question')

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

                    <li class="breadcrumb-item text-muted"> Quizzes </li>
                    <li class="breadcrumb-item text-muted"> Quizzes Question Edit </li>

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
                        <form method="POST" action="{{ route('admin.quizze_questions.update', $question->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="input-style-1 col-lg-6 mt-4">
                                    <label for="quizze_category_id">Category:</label>
                                    <select name="quizze_category_id" id="quizze_category_id" class="form-control @error('quizze_category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @if($question->quizze_category_id == $category->id) selected @endif>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('quizze_category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-style-1 col-lg-6 mt-4">
                                    <label for="question">Question:</label>
                                    <input type="text" placeholder="Enter Question" id="question"
                                        class="form-control @error('question') is-invalid @enderror" name="question"
                                        value="{{ $question->question ?? old('question') }}" />
                                    @error('question')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>

                            <div class="row">
                                <div class="input-style-1 col-lg-3 mt-4">
                                    <label for="answer">Answer:</label>
                                    <input type="text" placeholder="Enter Answer" id="answer"
                                        class="form-control @error('answer') is-invalid @enderror" name="answer"
                                        value="{{ $question->answer ?? old('answer') }}" />
                                    @error('answer')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-style-1 col-lg-3 mt-4">
                                    <label for="option1">Option 1:</label>
                                    <input type="text" placeholder="Enter Option 1" id="option1"
                                        class="form-control @error('option1') is-invalid @enderror" name="option1"
                                        value="{{ $question->option1 ?? old('option1') }}" />
                                    @error('option1')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-style-1 col-lg-3 mt-4">
                                    <label for="option2">Option 2:</label>
                                    <input type="text" placeholder="Enter Option 2" id="option2"
                                        class="form-control @error('option2') is-invalid @enderror" name="option2"
                                        value="{{ $question->option2 ?? old('option2') }}" />
                                    @error('option2')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="input-style-1 col-lg-3 mt-4">
                                    <label for="option3">Option 3:</label>
                                    <input type="text" placeholder="Enter Option 3" id="option3"
                                        class="form-control @error('option3') is-invalid @enderror" name="option3"
                                        value="{{ $question->option3 ?? old('option3') }}" />
                                    @error('option3')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('admin.quizze_questions.index') }}" class="btn btn-danger me-2">Cancel</a>
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
