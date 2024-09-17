@extends('partials.app')
@section('title', 'Products Page')
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
                        <a href="#">Products</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Products</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mx-4">
            <div class="card-header">
                @include('status')
                <h5>Products</h5>
                <div class="text-end">
                    <a href="{{ route('admin_product_addform') }}" class="btn btn-primary btn-sm">Add New Product</a>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables_all" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Brand</th>
                                <th>Product Name</th>
                                <th>Stock</th>
                                <th>MRP</th>
                                <th>Selling Price</th>
                                <th>Discount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $key=>$product)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td><img src="{{ asset('public/storage/' . $product->image) }}" alt=""
                                            width="64" height="64"></td>
                                    <td>{{ $product->category->category_name }}</td>
                                    <td>{{ $product->subCategory->subcategory_name }}</td>
                                    <td>{{ $product->brand->brand_name }}</td>

                                    <td>{{ $product->product_name }}</td>
                                    <td>{{ $product->total_stock }}</td>
                                    <td>{{ $product->mrp }}</td>
                                    <td>{{ $product->selling_price }}</td>
                                    <td>{{ $product->discount }}</td>
                                    <td>
                                        <a href="{{ route('admin_product_delete', ['id' => $product->id]) }}"
                                            onclick="return confirm('Are you sure delete this product.')"
                                            class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                            @empty
                                
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
