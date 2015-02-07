@section('js')
    <script src="{{ asset('js/admin/form.js') }}"></script>
@stop

@section('otherSideLink')
    @include('core::admin._navbar-public-link')
@stop


@include('core::admin._buttons-form')

{!! BootForm::hidden('id') !!}

@include('core::admin._image-fieldset', ['field' => 'image'])

@include('core::admin._tabs-lang')

<div class="tab-content">

    @foreach ($locales as $lang)

    <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
        @include('core::admin._title-and-slug')
        {!! BootForm::checkbox(trans('labels.online'), $lang.'[status]') !!}
    </div>

    @endforeach

</div>
