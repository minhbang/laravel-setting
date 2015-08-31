@extends('backend.layouts.main')
@section('content')

{!! Form::model($settings) !!}
<div class="row">
    <div class="col-md-8">
        <div class="ibox">
            <div class="ibox-title">
                <h5>{{ trans('setting::'.$section.'.description') }}</h5>
            </div>
            <div class="ibox-content">
                <div class="form-group{{ $errors->has("name_long") ? ' has-error':'' }}">
                    {!! Form::label("name_long", trans('setting::'.$section.'.fields.name_long'), ['class' => "control-label"]) !!}
                    {!! Form::text("name_long", null, ['class' => 'form-control']) !!}
                    @if($errors->has("name_long"))
                        <p class="help-block">{{ $errors->first("name_long") }}</p>
                    @endif
                </div>
                <div class="form-group{{ $errors->has("name_short") ? ' has-error':'' }}">
                    {!! Form::label("name_short", trans('setting::'.$section.'.fields.name_short'), ['class' => "control-label"]) !!}
                    {!! Form::text("name_short", null, ['class' => 'form-control']) !!}
                    @if($errors->has("name_short"))
                        <p class="help-block">{{ $errors->first("name_short") }}</p>
                    @endif
                </div>
                <div class="form-group{{ $errors->has("address") ? ' has-error':'' }}">
                    {!! Form::label("address", trans('setting::'.$section.'.fields.address'), ['class' => "control-label"]) !!}
                    {!! Form::text("address", null, ['class' => 'form-control']) !!}
                    @if($errors->has("address"))
                        <p class="help-block">{{ $errors->first("address") }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ibox">
            <div class="ibox-title">
                <h5></h5>
                <div class="ibox-tools">
                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="ibox-content">
                <div class="form-group{{ $errors->has('email') ? ' has-error':'' }}">
                    {!! Form::label('email', trans('setting::'.$section.'.fields.email'), ['class' => 'control-label']) !!}
                    {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    @if($errors->has('email'))
                        <p class="help-block">{{ $errors->first('email') }}</p>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('tel') ? ' has-error':'' }}">
                    {!! Form::label('tel', trans('setting::'.$section.'.fields.tel'), ['class' => 'control-label']) !!}
                    {!! Form::text('tel', null, ['class' => 'form-control']) !!}
                    @if($errors->has('tel'))
                        <p class="help-block">{{ $errors->first('tel') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ibox">
    <div class="ibox-content">
        <div class="form-group text-center">
                <button type="submit" class="btn btn-success" style="margin-right: 15px;">{{ trans('common.save') }}</button>
                <a href="{{ route('backend.setting.list') }}">{{ trans('common.cancel') }}</a>
        </div>
    </div>
</div>
{!! Form::close() !!}
@stop