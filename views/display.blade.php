@extends('backend.layouts.main')
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
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="form-group{{ $errors->has('image_width_max') ? ' has-error':'' }}">
                    {!! Form::label('image_width_max', trans('setting::'.$section.'.fields.image_width_max'), ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-7">
                        <div class="input-group">
                            {!! Form::text('image_width_max', null, ['class' => 'form-control']) !!}
                            <span class="input-group-addon">px</span>
                        </div>
                        @if($errors->has('image_width_max'))
                            <p class="help-block">{{ $errors->first('image_width_max') }}</p>
                        @else
                            <p class="help-block">{{ $errors->first('image_width_max_hint') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('image_width_md') ? ' has-error':'' }}">
                    {!! Form::label('image_width_md', trans('setting::'.$section.'.fields.image_width_md'), ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-7">
                        <div class="input-group">
                            {!! Form::text('image_width_md', null, ['class' => 'form-control']) !!}
                            <span class="input-group-addon">px</span>
                        </div>
                        @if($errors->has('image_width_md'))
                            <p class="help-block">{{ $errors->first('image_width_md') }}</p>
                        @else
                            <p class="help-block">{{ $errors->first('image_width_md_hint') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('image_height_md') ? ' has-error':'' }}">
                    {!! Form::label('image_height_md', trans('setting::'.$section.'.fields.image_height_md'), ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-7">
                        <div class="input-group">
                            {!! Form::text('image_height_md', null, ['class' => 'form-control']) !!}
                            <span class="input-group-addon">px</span>
                        </div>
                        @if($errors->has('image_height_md'))
                            <p class="help-block">{{ $errors->first('image_height_md') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('image_width_sm') ? ' has-error':'' }}">
                    {!! Form::label('image_width_sm', trans('setting::'.$section.'.fields.image_width_sm'), ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-7">
                        <div class="input-group">
                            {!! Form::text('image_width_sm', null, ['class' => 'form-control']) !!}
                            <span class="input-group-addon">px</span>
                        </div>
                        @if($errors->has('image_width_sm'))
                            <p class="help-block">{{ $errors->first('image_width_sm') }}</p>
                        @else
                            <p class="help-block">{{ $errors->first('image_width_sm_hint') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('image_height_sm') ? ' has-error':'' }}">
                    {!! Form::label('image_height_sm', trans('setting::'.$section.'.fields.image_height_sm'), ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-7">
                        <div class="input-group">
                            {!! Form::text('image_height_sm', null, ['class' => 'form-control']) !!}
                            <span class="input-group-addon">px</span>
                        </div>
                        @if($errors->has('image_height_sm'))
                            <p class="help-block">{{ $errors->first('image_height_sm') }}</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="form-group{{ $errors->has('summary_limit') ? ' has-error':'' }}">
                    {!! Form::label('summary_limit', trans('setting::'.$section.'.fields.summary_limit'), ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-7">
                        {!! Form::text('summary_limit', null, ['class' => 'form-control']) !!}
                        @if($errors->has('summary_limit'))
                            <p class="help-block">{{ $errors->first('summary_limit') }}</p>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('category_page_limit') ? ' has-error':'' }}">
                    {!! Form::label('category_page_limit', trans('setting::'.$section.'.fields.category_page_limit'), ['class' => 'col-md-5 control-label']) !!}
                    <div class="col-md-7">
                        {!! Form::text('category_page_limit', null, ['class' => 'form-control']) !!}
                        @if($errors->has('category_page_limit'))
                            <p class="help-block">{{ $errors->first('category_page_limit') }}</p>
                        @endif
                    </div>
                </div>
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