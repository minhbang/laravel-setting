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
                <div class="form-group{{ $errors->has("name") ? ' has-error':'' }}">
                    {!! Form::label("name", trans('setting::'.$section.'.fields.name'), ['class' => "control-label"]) !!}
                        {!! Form::text("name", null, ['class' => 'form-control']) !!}
                        @if($errors->has("name"))
                            <p class="help-block">{{ $errors->first("name") }}</p>
                        @endif
                </div>
                <div class="form-group{{ $errors->has("success") ? ' has-error':'' }}">
                    {!! Form::label("success", trans('setting::'.$section.'.fields.success'), ['class' => "control-label"]) !!}
                        {!! Form::textarea("success", null, ['class' => 'form-control']) !!}
                        @if($errors->has("success"))
                            <p class="help-block">{{ $errors->first("success") }}</p>
                        @else
                            <p class="help-block">{{ trans('setting::'.$section.'.fields.success_hint') }}</p>
                        @endif
                </div>
                <div class="form-group{{ $errors->has("form") ? ' has-error':'' }}">
                    {!! Form::label("form", trans('setting::'.$section.'.fields.form'), ['class' => "control-label"]) !!}
                        {!! Form::hidden("form", null, ['id' => "input-form"]) !!}
                        <div class="form-editor" data-input="#input-form">
                            <div id="form-editor-preview" class="form-editor-preview form-control"></div>
                            <div class="actions">
                                <a href="#" class="btn btn-xs btn-primary" data-type="text"><span class="glyphicon glyphicon-plus-sign"></span> Text Field</a>
                                <a href="#" class="btn btn-xs btn-success" data-type="textarea"><span class="glyphicon glyphicon-plus-sign"></span> Textarea Field</a>
                                <a href="#" class="btn btn-xs btn-warning" data-type="checkbox"><span class="glyphicon glyphicon-plus-sign"></span> Checkbox</a>
                            </div>
                        </div>
                        @if($errors->has("form"))
                            <p class="help-block">{{ $errors->first("form") }}</p>
                        @endif
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="ibox">
            <div class="ibox-title">
                <h5></h5>
            </ul>
            </div>
            <div class="ibox-content">
                <div class="form-group{{ $errors->has('enable') ? ' has-error':'' }}">
                    {!! Form::label('enable', trans('setting::'.$section.'.fields.enable'), ['class' => 'control-label']) !!}<br>
                        {!! Form::checkbox('enable', 1, null,['class'=>'switch', 'data-on-text'=>trans('common.yes'), 'data-off-text'=>trans('common.no')]) !!}
                        @if($errors->has('enable'))
                            <p class="help-block">{{ $errors->first('enable') }}</p>
                        @endif
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error':'' }}">
                    {!! Form::label('email', trans('setting::'.$section.'.fields.email'), ['class' => 'control-label']) !!}
                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                        @if($errors->has('email'))
                            <p class="help-block">{{ $errors->first('email') }}</p>
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

@section('script')
    @include('_form_editor_script', ['input_forms' => ['input-form' => 'form-editor-preview']])
@stop