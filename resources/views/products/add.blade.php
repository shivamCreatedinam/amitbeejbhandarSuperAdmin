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
                        <a href="#">Add New Product</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mx-4">
            <div class="card-header">
                @include('status')
                <h5>Add New Product</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin_product_store') }}" method="post" enctype="multipart/form-data">
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
                            <label for="sub_category_name">Sub Category Name <span class="text-danger">*</span></label>

                            <select name="sub_category_name" id="sub_category_name" class="form-control" required>
                                <option value="" selected disabled> -- Select Sub Category --</option>
                            </select>

                            @error('sub_category_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="col-md-4 form-group">
                            <label for="brand_name">Brand Name <span class="text-danger">*</span></label>

                            <select name="brand_name" id="brand_name" class="form-control" required>
                                <option value="" selected disabled> -- Select Brand --</option>

                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->brand_name }}</option>
                                @endforeach
                            </select>

                            @error('brand_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-4 form-group">
                            <label for="product_name">Product Name <span class="text-danger">*</span></label>
                            <input type="text" name="product_name" value="{{old('product_name')}}" class="form-control" id="product_name"
                                placeholder="Product Name" required>
                            @error('product_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 form-group">
                            <label for="product_image">Product Image </label>
                            <input type="file" name="product_image" class="form-control" id="product_image"
                                >
                            @error('product_image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                       


                        <!-- <div class="col-md-4 form-group">
                            <label for="total_stock">Total Stock <span class="text-danger">*</span></label>
                            <input type="text" name="total_stock" value="{{old('total_stock')}}" class="form-control" id="total_stock"
                                placeholder="Total Stock" required>
                            @error('total_stock')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> -->

                        <!-- <div class="col-md-4 form-group">
                            <label for="mrp">MRP <span class="text-danger">*</span></label>
                            <input type="text" name="mrp" value="{{old('mrp')}}" class="form-control" id="mrp"
                                placeholder="MRP" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" required>
                            @error('mrp')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> -->

                        <!-- <div class="col-md-4 form-group">
                            <label for="selling_price">Selling Price <span class="text-danger">*</span></label>
                            <input type="text" name="selling_price" value="{{old('selling_price')}}" class="form-control" id="selling_price" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')"
                                placeholder="Selling Price" required>
                            @error('selling_price')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> -->

                        <!-- <div class="col-md-4 form-group">
                            <label for="discount">Discount <span class="text-danger">*</span></label>
                            <input type="text" onkeyup="this.value=this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1')" value="{{old('discount')}}" name="discount" class="form-control" id="discount"
                                placeholder="Discount" required>
                            @error('discount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> -->

                        <div class="col-md-12 form-group">
                            <label for="short_desc">Short Desc <span class="text-danger">*</span></label>
                            <input type="text" name="short_desc" class="form-control" id="short_desc"
                                placeholder="Short Desc" value="{{old('short_desc')}}" required>
                            @error('short_desc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="long_desc">Long Desc <span class="text-danger">*</span></label>
                            <textarea name="long_desc" class="form-control" id="long_desc"
                            placeholder="Short Desc" required cols="30" rows="10">{{old('long_desc')}}</textarea>
                            @error('long_desc')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-md-6 form-group">
                            <label for="features">Features <span class="text-danger">*</span></label>
                            <textarea name="features" class="form-control" id="features"
                            placeholder="Features" required cols="30" rows="10">{{old('features')}}</textarea>
                            @error('features')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary float-end">Add Product</button>
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
