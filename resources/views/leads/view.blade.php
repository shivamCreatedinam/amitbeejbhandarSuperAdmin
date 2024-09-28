@extends('partials.app')
@section('title', 'Lead View')
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
                        <a href="{{ route('admin_lead_list') }}">Leads</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Lead View</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="card mx-4">
            <div class="card-header">
                <h5><a href="{{ route('admin_lead_list') }}"><i class="fas fa-arrow-alt-circle-left"
                    title="Back To List"></i></a> Lead Quotes
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive">
                        @php
                            // Check if JSON is valid and not empty
                            $quotes = $lead->quotes != null ? json_decode($lead->quotes, true) : [];
                            // Check if decoding was successful (i.e., valid JSON)
                            $isJsonValid = json_last_error() === JSON_ERROR_NONE;
                        @endphp

                        @if ($isJsonValid && is_array($quotes) && !empty($quotes))
                            <table class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Name</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <!-- <th>Technical Content</th> -->
                                        <th>Variant Name</th>
                                        <!-- <th>Size</th> -->
                                        <th>Stock</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($quotes as $key => $quote)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $quote['product_name'] ?? '' }}</td>
                                        <td>{{ $quote['brand']['brand_name'] ?? '' }}</td>
                                        <td>{{ $quote['category'] ?? 'N/A' }}</td>
                                        <td>{{ $quote['variantName'] ?? 'N/A' }}</td>
                                        <td>{{ $quote['stock'] ?? '-' }}</td>
                                        <td>{{ $quote['price'] ?? 'N/A' }}</td>
                                        <td>{{ $quote['quantity'] ?? '-' }}</td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8">No quotes available.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        @else
                            <p>Invalid or empty Quote List..</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
