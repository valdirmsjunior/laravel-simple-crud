@extends('layouts.layout')
@section('title', 'Deleted Products')

@section('content')
    <div class="container mt-3">
        @if (Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-danger">
                {{ Session::get('error') }}
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col">
                        <h2>Deleted Products</h2>
                    </div>
                    <div class="col">
                        <div class="row">
                            <div class="col-md-6">
                                <form class="d-flex" role="search" action="{{ route('products.index') }}" method="GET">
                                    @csrf
                                    <input class="form-control me-2" type="search" name="search" placeholder="Search"
                                        aria-label="Search" />
                                    <button class="btn btn-outline-success" type="submit">Search</button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col">
                                        <a href="{{ route('products.create') }}" class="btn btn-primary float-end">Add
                                            New</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table-striped table-hover table">
                    <thead class="text-center">
                        <tr>
                            <th>#
                                <a
                                    href="{{ route('products.trashed', ['sort' => 'id', 'direction' => $sort === 'id' && $direction === 'asc' ? 'desc' : 'asc']) }}">
                                    @if ($sort === 'id')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th>Name
                                <a
                                    href="{{ route('products.trashed', ['sort' => 'name', 'direction' => $sort === 'name' && $direction === 'asc' ? 'desc' : 'asc']) }}">

                                    @if ($sort === 'name')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th>Category
                                <a
                                    href="{{ route('products.trashed', ['sort' => 'category', 'direction' => $sort === 'category' && $direction === 'asc' ? 'desc' : 'asc']) }}">

                                    @if ($sort === 'category')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th>Quantity
                                <a
                                    href="{{ route('products.trashed', ['sort' => 'quantity', 'direction' => $sort === 'quantity' && $direction === 'asc' ? 'desc' : 'asc']) }}">

                                    @if ($sort === 'quantity')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th>Price
                                <a
                                    href="{{ route('products.trashed', ['sort' => 'price', 'direction' => $sort === 'price' && $direction === 'asc' ? 'desc' : 'asc']) }}">

                                    @if ($sort === 'price')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th>Status
                                <a
                                    href="{{ route('products.trashed', ['sort' => 'status', 'direction' => $sort === 'status' && $direction === 'asc' ? 'desc' : 'asc']) }}">

                                    @if ($sort === 'status')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                            <th>Description
                                <a
                                    href="{{ route('products.trashed', ['sort' => 'description', 'direction' => $sort === 'description' && $direction === 'asc' ? 'desc' : 'asc']) }}">

                                    @if ($sort === 'description')
                                        <span class="ms-2">{{ $direction === 'asc' ? '↑' : '↓' }}</span>
                                    @else
                                        <span class="ms-2">↕</span>
                                    @endif
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($deletedProducts->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">No products found.</td>
                            </tr>
                        @else
                            @foreach ($deletedProducts as $product)
                                <tr class="text-center">
                                    <td>{{ $product->id }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>${{ number_format($product->price, 2) }}</td>
                                    <td>{{ $product->status }}</td>
                                    <td>{{ $product->description }}</td>
                                    {{-- <td>
                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td> --}}
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{ $deletedProducts->links() }}
            </div>
        </div>
    </div>
@endsection
