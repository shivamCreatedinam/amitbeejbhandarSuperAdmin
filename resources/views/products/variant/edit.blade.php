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
                    <a href="{{ route('admin_sub_category_list') }}">Varient</a>
                </li>
                <li class="separator">
                    <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                    <a href="#">Edit Variant</a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card mx-4">
        <div class="card-header">
            @include('status')
            <h5>Edit Variant</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('variant_update', ['id' => $variant->id]) }}" method="post"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <!-- Uncomment if the image upload is required -->
                    <!-- 
                        <div class="col-md-4 form-group">
                            <label for="variant_image">Variant Image </label>
                            <input type="file" name="variant_image" class="form-control" id="variant_image">
                            @error('variant_image')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div> 
                    -->

                    <div class="col-md-4 form-group">
                        <label for="variant_name">Varient Name(Size) <span class="text-danger">*</span></label>
                        <input type="text" name="variant_name" value="{{ old('variant_name', $variant->variant_name) }}" class="form-control"
                            id="variant_name" placeholder="Enter size (e.g., 12KG(PACK OF 12*1KG))" required>
                        @error('variant_name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="quantity">Quantity <span class="text-danger">*</span></label>
                        <input type="number" name="quantity"
                            value="{{ old('quantity', $variant->quantity) }}" class="form-control"
                            id="quantity" placeholder="Variant Quantity" required>
                        @error('quantity')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="unit">Unit <span class="text-danger">*</span></label>
                        <select name="unit" class="form-control" id="unit" required>
                            <option value="" disabled>Select Unit</option>
                            <option value="ml" {{ old('unit', $variant->unit) == 'ml' ? 'selected' : '' }}>ml</option>
                            <option value="g" {{ old('unit', $variant->unit) == 'g' ? 'selected' : '' }}>g</option>
                            <option value="kg" {{ old('unit', $variant->unit) == 'kg' ? 'selected' : '' }}>kg</option>
                            <option value="l" {{ old('unit', $variant->unit) == 'l' ? 'selected' : '' }}>l</option>
                            <option value="oz" {{ old('unit', $variant->unit) == 'oz' ? 'selected' : '' }}>oz</option>
                            <!-- Add more unit options as needed -->
                        </select>
                        @error('unit')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="packing">Packing <span class="text-danger">*</span></label>
                        <input type="number" name="packing" value="{{ old('packing', $variant->packing) }}" class="form-control"
                            id="packing" placeholder="Enter Quantity (e.g., 1, 10)" min="0"  required>
                        @error('packing')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="total_stock">Total Stock <span class="text-danger">*</span></label>
                        <input type="number" name="total_stock" value="{{ old('total_stock', $variant->total_stock) }}"
                            class="form-control" id="total_stock" placeholder="Total Stock" min="0" required>
                        @error('total_stock')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="mrp">MRP <span class="text-danger">*</span></label>
                        <input type="number" name="mrp" value="{{ old('mrp', $variant->mrp) }}" class="form-control"
                            id="mrp" placeholder="MRP" min="0" step="0.01" required>
                        @error('mrp')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="selling_price">Selling Price <span class="text-danger">*</span></label>
                        <input type="number" name="selling_price"
                            value="{{ old('selling_price', $variant->selling_price) }}" class="form-control"
                            id="selling_price" placeholder="Selling Price" min="0" step="0.01" required>
                        @error('selling_price')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="discount">Discount <span class="text-danger">*</span></label>
                        <input type="number" name="discount" value="{{ old('discount', $variant->discount) }}"
                            class="form-control" id="discount" placeholder="Discount" min="0" step="0.01" required>
                        @error('discount')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-primary float-end">Update Variant</button>
            </form>



        </div>
    </div>
</div>
@endsection