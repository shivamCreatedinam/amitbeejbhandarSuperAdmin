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
                        <a href="#">Variants</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mx-4">
            <div class="card-header">
                @include('status')
                <h5>Variants</h5>
                <div class="text-end">
                <a href="{{ route('variant_addForm',['id' => $product_id]) }}" class="btn btn-primary btn-sm">Add Varient</a>

                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover dataTables_all" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <!-- <th>Image</th> -->
                                <th>Variant Name</th>
                                <th>Quantity</th>
                                <th>Stock</th>
                                <th>MRP</th>
                                <th>Selling Price</th>
                                <th>Discount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($variants as $key=>$variant )
                        <tr>
                            <td>{{$key+1}}</td>
                            <td>{{$variant->variant_name}}</td>
                            <td>{{$variant->quantity}}</td>
                            <td>{{$variant->total_stock}}</td>
                            <td>{{$variant->mrp}}</td>
                            <td>{{$variant->selling_price}}</td>
                            <td>{{$variant->discount}}</td>
                           <td>
                           <a href="{{ route('variant_editForm', ['id' => $variant->id]) }}"
                                            class="btn btn-primary btn-sm">  <i class="bi bi-pencil-square"></i> </a>
                           <a href="{{ route('variant_delete', ['id' => $variant->id]) }}"
                                            onclick="return confirm('Are you sure delete this variant.')"
                                            class="btn btn-danger btn-sm"> <i class="bi bi-trash"></i></a>
                           </td>

                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection


