@extends('layouts.layout')
@section('title', 'Edit Product')

@section('content')
    <div class="container mb-5 mt-3">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2>Edit Product</h2>
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
                <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    @include('product.form')
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
