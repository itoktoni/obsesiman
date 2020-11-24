@extends(Helper::setExtendBackend())
@section('content')
<div class="row">
    <div class="panel-body">
        @isset($model->$key)
        {!! Form::model($model, ['route'=>[$action_code, 'code' => $model->$key],'class'=>'form-horizontal
        ','files'=>true])
        !!}
        @else
        {!! Form::open(['route' => $action_code, 'class' => 'form-horizontal', 'files' => true]) !!}
        @endisset
        <div class="panel panel-default">

            <header class="panel-heading">
                @isset($model->$key)
                <h2 class="panel-title">Edit {{ ucwords(str_replace('_',' ',$template)) }} : {{ $model->$key }}</h2>
                @else
                <h2 class="panel-title">Create {{ ucwords(str_replace('_',' ',$template)) }}</h2>
                @endisset
            </header>

            <div class="panel-body line">
                <div class="">
                   
                    <div class="form-group">
                        {!! Form::label('name', 'Customer', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('laundry_customer_id') ? 'has-error' : ''}}">
                            {{ Form::select('laundry_customer_id', $customers, null, ['class'=> 'form-control', 'id' => 'promo_id']) }}
                            {!! $errors->first('laundry_customer_id', '<p class="help-block">:message</p>') !!}
                        </div>

                        {!! Form::label('name', 'Tanggal', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('laundry_date') ? 'has-error' : ''}}">
                            {!! Form::text('laundry_date', $model->laundry_date ?? date('Y-m-d'),
                            ['class' =>
                            'form-control date']) !!}
                            {!! $errors->first('laundry_date', '<p class="help-block">:message</p>') !!}
                        </div>

                    </div>

                    <div class="form-group">
                        {!! Form::label('name', 'Active', ['class' => 'col-md-2 control-label']) !!}
                        <div class="col-md-4 {{ $errors->has('laundry_status') ? 'has-error' : ''}}">
                            {{ Form::select('laundry_status', [1 => 'Yes', 0 => 'No'], null, ['class'=> 'form-control', 'data-plugin-selectTwo']) }}
                            {!! $errors->first('laundry_status', '<p class="help-block">:message</p>') !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="navbar-fixed-bottom" id="menu_action">
                <div class="text-right" style="padding:5px">
                    <a id="linkMenu" href="{!! route($module.'_data') !!}" class="btn btn-warning">Back</a>
                    @if($action_function == 'update')
                    <a target="__blank" href="{!! route($module.'_print_order', ['code'=> $model->{$key}]) !!}"
                        class="btn btn-danger">Invoice</a>
                    @endif
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>

        </div>
        @include($folder.'::page.'.$template.'.detail')
        {!! Form::close() !!}

    </div>
</div>

@include($folder.'::page.'.$template.'.script')

@endsection