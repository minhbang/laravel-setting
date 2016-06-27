@extends('backend.layouts.master')
@section('content')
    {!! Form::model($section->values(), ['method' => 'post', 'url' => $update_url]) !!}
    <div class="row">
        <div class="col-md-8">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>{{ $section->description }}</h5>
                </div>
                <div class="ibox-content">
                    {!! $html->textField('name') !!}
                    {!! $html->textareaField('success') !!}
                    {!! $html->field('form',
                        Form::hidden("form", null, ['id' => "input-form"]).
                        '<div class="form-editor" data-input="#input-form">
                            <div id="form-editor-preview" class="form-editor-preview form-control"></div>
                            <div class="actions">
                                <a href="#" class="btn btn-xs btn-primary" data-type="text"><i class="fa fa-plus"></i> Text Field</a>
                                <a href="#" class="btn btn-xs btn-success" data-type="textarea"><i class="fa fa-plus"></i> Textarea Field</a>
                                <a href="#" class="btn btn-xs btn-warning" data-type="checkbox"><i class="fa fa-plus"></i> Checkbox</a>
                            </div>
                        </div>'
                    ) !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5></h5>
                </div>
                <div class="ibox-content">
                    {!! $html->checkboxField('enable') !!}
                    {!! $html->textField('email') !!}
                </div>
            </div>
        </div>
    </div>
    <div class="ibox">
        <div class="ibox-content">
            <div class="form-group text-center">
                {!! $html->buttons($return_url) !!}
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('script')
    @include('_form_editor_script', ['input_forms' => ['input-form' => 'form-editor-preview']])
    <script type="text/javascript">
        $(document).ready(function () {
            $('.wysiwyg').mbEditor();
        });
    </script>
@stop