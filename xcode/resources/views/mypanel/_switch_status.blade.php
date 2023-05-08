<div class="custom-control custom-switch">
    <input @isset($disabled) disabled @endisset id="{{ $url }}" onclick="switchChange('{{ $url }}')" class="custom-control-input" type="checkbox"
           @if($checked) checked @endif>
    <label for="{{ $url }}" class="custom-control-label @if($checked) fw-bold @endif">{{ $name }}</label>
</div>
