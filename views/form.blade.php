@extends('kit::backend.layouts.master')
@section('content')
    {!! Form::model($section->values(), ['class' => 'form-horizontal', 'method' => 'post', 'url' => $update_url]) !!}
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ $section->description }}</h5>
        </div>
        <div class="ibox-content">
            {!!  $html->editFields() !!}
            <div class="hr-line-dashed"></div>
            {!! $html->buttons($return_url) !!}
        </div>
    </div>
    {!! Form::close() !!}
@stop

@push('scripts')
    @if($section->getFormField())
        @include('kit::_form_editor_script', ['input_forms' => ['input-form' => 'form-editor-preview']])
    @endif
    <script type="text/javascript">
        $(document).ready(function () {
            $('.wysiwyg').mbEditor();
        });
    </script>
@endpush