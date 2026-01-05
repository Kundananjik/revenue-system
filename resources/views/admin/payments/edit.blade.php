@extends('admin.layouts.app')

@section('title', 'Edit Payment')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-6">Edit Payment</h1>

    <form action="{{ route('admin.payments.update', $payment->id) }}" method="POST">
        @csrf
        @method('PUT')

        @include('admin.payments.partials.form', ['payment' => $payment])

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update Payment</button>
    </form>
</div>
@endsection
