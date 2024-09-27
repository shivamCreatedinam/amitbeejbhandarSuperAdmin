@extends('partials.app')
@section('title', 'Add Product Page')
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
                        <a href="{{ route('admin_sub_category_list') }}">Product</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Edit Product</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mx-4">
            <div class="card-header">
                @include('status')
                <h5>Edit Product</h5>
            </div>
            <div class="card-body">
            <form action="{{ route('admin_product_update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-4 form-group">
                        <label for="category_name">Category Name <span class="text-danger">*</span></label>
                        <select name="category_name" id="category_name" class="form-control" required>
                            <option value="" disabled>-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->category_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="sub_category_name">Sub Category Name <span class="text-danger">*</span></label>
                        <select name="sub_category_name" id="sub_category_name" class="form-control" required>
                            <option value="" disabled>-- Select Sub Category --</option>
                            @foreach ($subCategories as $subCategory)
                                <option value="{{ $subCategory->id }}" {{ $product->sub_category_id == $subCategory->id ? 'selected' : '' }}>
                                    {{ $subCategory->subcategory_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sub_category_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="brand_name">Brand Name <span class="text-danger">*</span></label>
                        <select name="brand_name" id="brand_name" class="form-control" required>
                            <option value="" disabled>-- Select Brand --</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->brand_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('brand_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="product_name">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="product_name" value="{{ $product->product_name }}" class="form-control" id="product_name" placeholder="Product Name" required>
                        @error('product_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        <label for="product_image">Product Image</label>
                        <input type="file" name="product_image" class="form-control" id="product_image">
                       
                        @error('product_image')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-4 form-group">
                        @if($product->image)
                            <small>Current Image: <img src="{{ asset('public/storage/' . $product->image) }}" width="100"></small>
                        @endif
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="technical_name">Technical Name <span class="text-danger">*</span></label>
                        <input type="text" name="technical_name" value="{{ $product->technical_name }}" class="form-control" id="technical_name" placeholder="Technical Name" required>
                        @error('technical_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group">
                        <label for="short_desc">Short Desc <span class="text-danger">*</span></label>
                        <input type="text" name="short_desc" value="{{ $product->short_desc }}" class="form-control" id="short_desc" placeholder="Short Desc" required>
                        @error('short_desc')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="long_desc">Long Desc <span class="text-danger">*</span></label>
                        <textarea name="long_desc" class="form-control" id="long_desc" placeholder="Long Desc" required cols="30" rows="10">{{ $product->long_desc }}</textarea>
                        @error('long_desc')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="features">Features <span class="text-danger">*</span></label>
                        <textarea name="features" class="form-control" id="features" placeholder="Features" required cols="30" rows="10">{{ $product->features }}</textarea>
                        @error('features')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-end">Update Product</button>
            </form>

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $("#category_name").on("change", function() {
                let cat_id = $(this).val();
                let url = `{{url('/admin/product/get-sub-cat')}}/${cat_id}`

                $.ajax({
                    type: "get",
                    url: url,
                    success: function(response) {
                        if(response.status == true){
                            $("#sub_category_name").html(response.data)
                        }else{
                            alert("some error occured.")
                        }

                    }
                });
            })
        });
    </script>
@endpush
