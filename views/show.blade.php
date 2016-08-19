@extends('backend.layouts.master')
@section('content')
    <div class="ibox">
        <div class="ibox-title">
            <h5>{{ $section->special_title }}</h5>
        </div>
        <div class="ibox-content">
            <table class="table table-hover table-striped table-bordered table-detail">
                {!! $html->showFields() !!}
            </table>
        </div>
    </div>
@stop
@section('script')
    @if($field = $section->getFormField())
        @include('_form_show_script', ['form' => $values[$field]])
    @endif
@stop