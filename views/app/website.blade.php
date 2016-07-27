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
                    {!! $html->textField('name_app') !!}
                    {!! $html->textField('name_long') !!}
                    {!! $html->textField('name_short') !!}
                    {!! $html->textField('address') !!}
                    {!! $html->textareaField('header') !!}
                    {!! $html->textareaField('product_footer') !!}
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ibox">
                <div class="ibox-title">
                    <h5></h5>
                </div>
                <div class="ibox-content">
                    {!! $html->textField('email') !!}
                    {!! $html->textField('tel') !!}
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('.wysiwyg').mbEditor();
        });
    </script>
@stop