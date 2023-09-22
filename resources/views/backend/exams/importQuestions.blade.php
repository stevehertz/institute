@extends('backend.layouts.app')

@section('title', __('strings.backend.dashboard.title').' | '.app_name())
@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="page-title float-left mb-0">Import exam questions</h3>
            @can('question_create')
                <div class="float-right">
                    <a href="{{ route('admin.exam_questions.create') }}"
                       class="btn btn-success">@lang('strings.backend.general.app_add_new')</a>
                    <a href="{{ route('admin.questions.import1') }}"
                       class="btn btn-success">Import Questions</a>
                </div>
            @endcan
        </div>

<form method="post" enctype="multipart/form-data" action="{{ route('admin.questions.import') }}">
    {{ csrf_field() }}
    <div class="form-group">
        <table class="table">
            <tr>
                <td width="40%" align="right"><label>Select File for Upload</label></td>
                <td width="30">
                    <input type="file" name="select_file"/>
                </td>
                <td width="30%" align="left">
                    <input type="submit" name="upload" class="btn btn-primary" value="Upload">
                </td>
            </tr>
            <tr>
                <td width="40%" align="right"></td>
                <td width="30"><span class="text-muted">Accepted formats: .xls, .xslx</span></td>
                <td width="30%" align="left"></td>
            </tr>
        </table>
    </div>
</form>
    </div>
@endsection