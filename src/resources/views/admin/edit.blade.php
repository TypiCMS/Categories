@extends('core::admin.master')

@section('title', $model->present()->title)

@section('content')

    @include('core::admin._button-back', ['module' => 'categories'])
    <h1 class="@if(!$model->present()->title)text-muted @endif">
        {{ $model->present()->title ?: __('Untitled') }}
    </h1>

    {!! BootForm::open()->put()->action(route('admin::update-category', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('categories::admin._form')
    {!! BootForm::close() !!}

@endsection
