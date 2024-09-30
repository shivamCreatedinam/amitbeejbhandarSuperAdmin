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
            <h5>Products <span style="color:red;">(Must add variant in each and every product!)</span>
            </h5>
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
                            <th>Variants</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($products as $key => $product)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td><img src="{{ asset('public/storage/' . $product->image) }}" alt="" width="64"
                                        height="64"></td>
                                <td>{{ $product->category->category_name }}</td>
                                <td>{{ $product->subCategory->subcategory_name }}</td>
                                <td>{{ $product->brand->brand_name }}</td>
                                <td>{{ $product->product_name }}</td>
                              
                                <td>
                                @if ($product->variants->count() > 0)
                                    <a href="{{ route('product_variant_list', ['id' => $product->id]) }}"
                                    class="btn btn-success btn-sm">Variant <i class="bi bi-list"></i></a>
                                @else
                                    <a href="{{ route('product_variant_list', ['id' => $product->id]) }}"
                                    class="btn btn-danger btn-sm">Variant <i class="bi bi-plus"></i></a>
                                @endif
                                    
                                </td>
                                <td>
                                    <a href="{{ route('admin_product_edit', ['id' => $product->id]) }}"
                                    class="btn btn-info btn-sm" style="margin-right: 10px;"> <!-- Add custom margin -->
                                        <i class="bi bi-pencil-square"></i> <!-- Edit Icon -->
                                    </a>

                                    <a href="{{ route('admin_product_delete', ['id' => $product->id]) }}"
                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                    class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> <!-- Delete Icon -->
                                    </a>
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