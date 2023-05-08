<label class="form-label" for="{{$variabel}}">{{$label}}</label>
<input
    class="form-control {{$invalid ?? ''}}"
    name="{{$variabel}}" id="{{$variabel}}" type="text" value="{{ $value }}"/>
@if('invalid')
    <div class="invalid-feedback">
        {{ $message ?? '' }}
    </div>
@endif

<!-- CONTOH PENGGUNAAN -->
{{--@component('components.textInput')--}}
{{--    @slot('variabel')--}}
{{--        name--}}
{{--    @endslot--}}
{{--    @slot('label')--}}
{{--        Nama Lengkap--}}
{{--    @endslot--}}
{{--    @slot('value')--}}
{{--        {{$row->name}}--}}
{{--    @endslot--}}
{{--    @error('name')--}}
{{--    @slot('invalid')--}}
{{--        is-invalid--}}
{{--    @endslot--}}
{{--    @slot('message')--}}
{{--        {{ $message }}--}}
{{--    @endslot--}}
{{--    @enderror--}}
{{--@endcomponent--}}
