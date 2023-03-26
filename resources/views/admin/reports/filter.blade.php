<form action="{{ url()->current() }}" method="get" class="row">
    <div class="col-lg-3">
        <div class="form-group mb-2">
            <input type="text" class="form-control datepicker" readonly="" value="{{ !empty(request()->input('start')) ? request()->input('start') : '' }}" name="start" placeholder="from">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group mx-sm-3 mb-2">
            <input type="text" class="form-control datepicker" readonly="" value="{{ !empty(request()->input('end')) ? request()->input('end') : '' }}" name="end" placeholder="to">
        </div>
    </div>
    <div class="col-lg-3">
        <div class="form-group mx-sm-3 mb-2">
            <select name="export" id="export" class="form-control input-block">
                @foreach($exports as $value => $export)
                    <option value="{{ $value }}">{{ $export }}</option>
                @endforeach
            </select>
        </div>   
    </div>
    <div class="col-lg-2">
        <div class="form-group mx-sm-3 mb-2">
            <button type="submit" class="btn btn-success">Go</button>
        </div>
    </div>
</form>