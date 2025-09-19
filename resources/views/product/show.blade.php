@extends('layouts.layout')
@section('title', 'Product Details')

@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2>Product Details</h2>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('products.index') }}" class="btn btn-primary float-end">
                                            Back to List </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table-bordered table">
                    <tr>
                        <th>ID</th>
                        <td>{{ $product->id }}</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td>{{ $product->description }}</td>
                    </tr>
                    <tr>
                        <th>Price</th>
                        <td>${{ number_format($product->price, 2) }}</td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td>{{ $product->category ? $product->category->name : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><span
                                class="badge text-bg-{{ $product->status->value === 'active' ? 'success' : 'secondary' }}">{{ $product->status->value }}</span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
@endsection
