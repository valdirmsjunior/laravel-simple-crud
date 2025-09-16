@extends('layouts.layout')
@section('title', 'Create Product')
@section('content')
    <div class="container mt-3">
        <div class="card">
            <div class="card-header">
                <h2>Add new Product</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @include('product.form')

                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>

    </div>

@endsection
