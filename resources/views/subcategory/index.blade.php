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
                        <a href="#">Sub Category</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Sub Categories</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card mx-4">
            <div class="card-header">
                @include('status')
                <h5>Sub Category</h5>
                <div class="text-end">
                    <a href="{{route('admin_sub_category_addform')}}" class="btn btn-primary btn-sm">Add New Sub Category</a>
                </div>
            </div>
            <div class="card-body">

                <div class="table-responsive">
                    <table class="dataTables_all table table-striped table-bordered table-hover" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Sub Category Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($sub_categories as $key=>$category)

                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$category->category->category_name}}</td>
                                <td>{{$category->subcategory_name}}</td>
                                <td>
                                    <a href="{{route('admin_sub_category_delete',['id'=>$category->id])}}" onclick="return confirm('Are you sure delete this sub category.')" class="btn btn-danger btn-sm" >Delete</a>
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
