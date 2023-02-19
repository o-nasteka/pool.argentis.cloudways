@php
    if(isset($dataTypeContent->{$row->field}) && !empty($dataTypeContent->{$row->field})){
        $dataArr = json_decode($dataTypeContent->{$row->field}, true);
    } else {
        $dataArr = [];
    }

@endphp
   <div class="border" style="border: #e4eaec 1px solid; padding: 15px; color: #76838f;">
        @if(isset($dataTypeContent->{$row->field}))

            @foreach($dataArr as $key => $value)
                @if( !is_array($key) && !is_array($value))
                    <p>
                        <strong>{!! $key !!}</strong> : {!!  $value !!}
                    </p>
                @else
                    @foreach($value as $key => $val)
                       <p>
                           <strong>{{ $key }}</strong> : {{ $val }}
                       </p>
                    @endforeach
                @endif
            @endforeach

        @else
            {{old($row->field)}}
        @endif
   </div>

