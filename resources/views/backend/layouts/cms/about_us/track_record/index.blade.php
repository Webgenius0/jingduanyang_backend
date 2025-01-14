@extends('backend.app')

@section('title', 'Cms || About Us Track Record')

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
                    <li class="breadcrumb-item text-muted"> About Us Track Record</li>

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
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-body">
                                <h3 class="card-title">Total Empowered Clients</h3>
                                <form method="POST" action="{{ route('cms.empowered_clients.store') }}">
                                    @csrf
                                    <div class="input-style-1 mt-4">
                                        <label for="empowered_clients">Total Empowered Clients:</label>
                                        <input type="text" placeholder="Enter Total Empowered Clients" id="empowered_clients"
                                            class="form-control @error('empowered_clients') is-invalid @enderror"
                                            name="empowered_clients" value="{{ $empowered_client->title ?? old('empowered_clients') }}" />
                                        @error('empowered_clients')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-body">
                                <h3 class="card-title">Patients Satisfaction</h3>
                                <form method="POST" action="{{ route('cms.patients_satisfaction.store') }}">
                                    @csrf
                                    <div class="input-style-1 mt-4">
                                        <label for="total_satisfaction">Total Satisfaction (%):</label>
                                        <input type="number" min="0" max="100" placeholder="Enter Total Satisfaction" id="total_satisfaction"
                                            class="form-control @error('total_satisfaction') is-invalid @enderror"
                                            name="total_satisfaction"
                                            value="{{ $patient_satisfaction->title ?? old('total_satisfaction') }}" />
                                        @error('total_satisfaction')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-secondary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-body">
                                <h3 class="card-title">Total Years of Experience</h3>
                                <form method="POST" action="{{ route('cms.years_of_experience.store') }}">
                                    @csrf
                                    <div class="input-style-1 mt-4">
                                        <label for="experience">Total Experience:</label>
                                        <input type="text" placeholder="Enter Total Experience" id="experience"
                                            class="form-control @error('experience') is-invalid @enderror"
                                            name="experience"
                                            value="{{ $experience->title ?? old('experience') }}" />
                                        @error('experience')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-info">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card card-body">
                                <h3 class="card-title">Total Certified Expert</h3>
                                <form method="POST" action="{{ route('cms.certified_expert.store') }}">
                                    @csrf
                                    <div class="input-style-1 mt-4">
                                        <label for="certified_expert">Total Certified Expert:</label>
                                        <input type="text" placeholder="Enter Certified Expert" id="certified_expert"
                                            class="form-control @error('certified_expert') is-invalid @enderror"
                                            name="certified_expert"
                                            value="{{ $certified_expert->title ?? old('certified_expert') }}" />
                                        @error('certified_expert')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-warning">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card card-body">
                                <h3 class="card-title">Total Employees</h3>
                                <form method="POST" action="{{ route('cms.total_employees.store') }}">
                                    @csrf
                                    <div class="input-style-1 mt-4">
                                        <label for="employees">Total Employees:</label>
                                        <input type="text" placeholder="Enter Total Employees" id="employees"
                                            class="form-control @error('employees') is-invalid @enderror"
                                            name="employees" value="{{ $total_employees->title ?? old('employees') }}" />
                                        @error('employees')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-success">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('script')
@endpush
