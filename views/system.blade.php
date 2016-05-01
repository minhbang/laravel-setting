@extends('backend.layouts.master')
@section('content')
<div class="ibox">
    <div class="ibox-title">
        <h5>{{ trans('setting::'.$section.'.description') }}</h5>
        <div class="ibox-tools">
            <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
        </div>
    </div>
    <div class="ibox-content">
        {!! Form::model($settings, ['class' => 'form-horizontal']) !!}
        <div class="form-group{{ $errors->has('minify_html') ? ' has-error':'' }}">
            {!! Form::label('minify_html', trans('setting::'.$section.'.fields.minify_html'), ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::checkbox('minify_html', 1, null,['class'=>'switch', 'data-on-text'=>trans('common.yes'), 'data-off-text'=>trans('common.no')]) !!}
                @if($errors->has('minify_html'))
                    <p class="help-block">{{ $errors->first('minify_html') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('public_files') ? ' has-error':'' }}">
            {!! Form::label('public_files', trans('setting::'.$section.'.fields.public_files'), ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-6">
                {!! Form::text('public_files', null, ['class' => 'form-control']) !!}
                @if($errors->has('public_files'))
                    <p class="help-block">{{ $errors->first('public_files') }}</p>
                @else
                    <p class="help-block">{{ trans('setting::'.$section.'.fields.public_files_hint') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('max_image_size') ? ' has-error':'' }}">
            {!! Form::label('max_image_size', trans('setting::'.$section.'.fields.max_image_size'), ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-2">
                <div class="input-group">
                    {!! Form::text('max_image_size', null, ['class' => 'form-control']) !!}
                    <span class="input-group-addon">Mb</span>
                </div>
                @if($errors->has('max_image_size'))
                    <p class="help-block">{{ $errors->first('max_image_size') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('ga_tracking_id') ? ' has-error':'' }}">
            {!! Form::label('ga_tracking_id', trans('setting::'.$section.'.fields.ga_tracking_id'), ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('ga_tracking_id', null, ['class' => 'form-control']) !!}
                @if($errors->has('ga_tracking_id'))
                    <p class="help-block">{{ $errors->first('ga_tracking_id') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('fb_app_id') ? ' has-error':'' }}">
            {!! Form::label('fb_app_id', trans('setting::'.$section.'.fields.fb_app_id'), ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('fb_app_id', null, ['class' => 'form-control']) !!}
                @if($errors->has('fb_app_id'))
                    <p class="help-block">{{ $errors->first('fb_app_id') }}</p>
                @endif
            </div>
        </div>
        <div class="form-group{{ $errors->has('fb_api_ver') ? ' has-error':'' }}">
            {!! Form::label('fb_api_ver', trans('setting::'.$section.'.fields.fb_api_ver'), ['class' => 'col-md-4 control-label']) !!}
            <div class="col-md-8">
                {!! Form::text('fb_api_ver', null, ['class' => 'form-control']) !!}
                @if($errors->has('fb_api_ver'))
                    <p class="help-block">{{ $errors->first('fb_api_ver') }}</p>
                @endif
            </div>
        </div>
        <div class="hr-line-dashed"></div>
        <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-success" style="margin-right: 15px;">{{ trans('common.save') }}</button>
                <a href="{{ route('backend.setting.list') }}">{{ trans('common.cancel') }}</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop