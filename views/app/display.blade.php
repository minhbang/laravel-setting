@extends('backend.layouts.master')
@section('content')
    {!! Form::model($section->values(), ['class' => 'form-horizontal', 'method' => 'post', 'url' => $update_url]) !!}
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ $section->description }}</h5>
        </div>
        <div class="ibox-content">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    {!! $html->textField('image_width_max', ['label_size' => 'col-md-5', 'input_size' => 'col-md-7', 'addon' => 'px']) !!}
                    {!! $html->textField('image_width_md', ['label_size' => 'col-md-5', 'input_size' => 'col-md-7', 'addon' => 'px']) !!}
                    {!! $html->textField('image_height_md', ['label_size' => 'col-md-5', 'input_size' => 'col-md-7', 'addon' => 'px']) !!}
                    {!! $html->textField('image_width_sm', ['label_size' => 'col-md-5', 'input_size' => 'col-md-7', 'addon' => 'px']) !!}
                    {!! $html->textField('image_height_sm', ['label_size' => 'col-md-5', 'input_size' => 'col-md-7', 'addon' => 'px']) !!}
                </div>
                <div class="col-lg-6 col-md-12">
                    {!! $html->textField('summary_limit', ['label_size' => 'col-md-5', 'input_size' => 'col-md-7']) !!}
                    {!! $html->textField('category_page_limit', ['label_size' => 'col-md-5', 'input_size' => 'col-md-7']) !!}
                </div>
            </div>
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