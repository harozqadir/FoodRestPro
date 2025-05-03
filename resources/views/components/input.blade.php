<div>
    <div class="col-md-4 mt-3 postion-relative">
        <label for="{{$name}}" class="form-label">{{$title}}</label>
        <input type="{{$type}}" id="{{$name}}" value="{{ $dt ? $dt[$name]: old($name)}}" class="form-control"  name="{{$name}}" >
        @error($name)
        <div class="text-danger">{{ $message }}</div>
        @enderror
</div>