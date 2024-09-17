@extends('partials.app')
@section('title', 'Add Brand Page')
@section('container')
    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h4 class="page-title">Dashboard</h4>
                <ul class="breadcrumbs">
                    <li class="nav-home">
                        <a href="{{ route('dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('admin_brand_list')}}">Brands</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Add New Brand</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mx-4">
            <div class="card-header">
                @include('status')
                <h5>Add New Brand</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin_brand_store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label for="brand_name">Brand Name <span class="text-danger">*</span></label>
                            <input type="text" name="brand_name" class="form-control" id="brand_name"
                                 placeholder="Brand Name">
                            @error('brand_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end">Add Brand</button>
                </form>
            </div>
        </div>
    </div>
@endsection
