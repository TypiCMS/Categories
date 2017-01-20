@extends('core::admin.master')

@section('title', __('categories::global.New'))

@section('main')

    @include('core::admin._button-back', ['module' => 'categories'])
    <h1>
        @lang('categories::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-categories'))->multipart()->role('form') !!}
        @include('categories::admin._form')
    {!! BootForm::close() !!}

@endsection
