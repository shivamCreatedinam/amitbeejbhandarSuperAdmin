@extends('partials.app')
@section('title', 'Sub Category Page')
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
                        <a href="{{ route('admin_sub_category_list') }}">Sub Category</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Add New Sub Category</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mx-4">
            <div class="card-header">
                @include('status')
                <h5>Add New Sub Category</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin_sub_category_store') }}" method="post">
                    @csrf
                    <div class="row">

                        <div class="col-md-4 form-group">
                            <label for="category_name">Category Name <span class="text-danger">*</span></label>

                            <select name="category_name" id="category_name" class="form-control" required>
                                <option value="" selected disabled> -- Select Category --</option>

                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                @endforeach
                            </select>

                            @error('category_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="category_name">Sub Category Name <span class="text-danger">*</span></label>
                            <input type="text" name="subcategory_name" class="form-control" id="category_name"
                                placeholder="Sub Category Name" required>
                            @error('subcategory_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary float-end">Add Sub Category</button>
                </form>
            </div>
        </div>
    </div>
@endsection
