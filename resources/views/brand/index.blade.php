@extends('partials.app')
@section('title', 'Brand Page')
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
                        <a href="#">Brand</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Brands</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mx-4">
            <div class="card-header">
                @include('status')
                <h5>Brands</h5>
                <div class="text-end">
                    <a href="{{route('admin_brand_addform')}}" class="btn btn-primary btn-sm">Add New Brand</a>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="dataTables_all table table-striped table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Brand Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($brands as $key=>$brand)

                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$brand->brand_name}}</td>
                                <td>
                                    <a href="{{route('admin_brand_delete',['id'=>$brand->id])}}" onclick="return confirm('Are you sure delete this brand.')" class="btn btn-danger btn-sm" >Delete</a>
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
