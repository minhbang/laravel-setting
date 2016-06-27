@extends('backend.layouts.master')
@section('content')
    {!! Form::model($section->values(), ['class' => 'form-horizontal', 'method' => 'post', 'url' => $update_url]) !!}
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ $section->description }}</h5>
        </div>
        <div class="ibox-content">
            {!! $html->field('minify_html', Form::checkbox('minify_html', 1, null,['class'=>'switch', 'data-on-text'=>trans('common.yes'), 'data-off-text'=>trans('common.no')]), 'col-md-4', 'col-md-8') !!}
            {!! $html->textField('public_files', ['label_size' => 'col-md-4', 'input_size' => 'col-md-6']) !!}
            {!! $html->textField('max_image_size', ['label_size' => 'col-md-4', 'input_size' => 'col-md-2', 'addon' => 'Mb']) !!}
            {!! $html->textField('ga_tracking_id', ['label_size' => 'col-md-4', 'input_size' => 'col-md-8']) !!}
            {!! $html->textField('fb_app_id', ['label_size' => 'col-md-4', 'input_size' => 'col-md-8']) !!}
            {!! $html->textField('fb_api_ver', ['label_size' => 'col-md-4', 'input_size' => 'col-md-8']) !!}
            <div class="hr-line-dashed"></div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    {!! $html->buttons($return_url) !!}
                </div>
            </div>

        </div>
    </div>
    {!! Form::close() !!}
@stop