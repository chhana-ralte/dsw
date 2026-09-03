<x-att-layout>
    <x-block>
        <x-slot name="heading">
            Attendance for {{ $attmaster->subject_code }} : {{ $attmaster->subject_name }}
            <p>
                <a class="btn btn-primary btn-sm" href="#">Create</a>
            </p>
        </x-slot>
        <div style="width: 100%; overflow-x: auto">
            <table class="table">
                <tr>
                    <th>Sl</th><th>Rollno</th><th>Name</th>
                    @foreach($attslots as $as)
                        <th>{{ date_format(date_create($as->dt), 'd-M') }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
                <?php $sl=1 ?>
                @foreach($stds as $std)
                <tr>
                    <td>{{ $sl++ }}</td>
                    <td>{{ $std->rollno }}</td>
                    <td>{{ $std->name }}</td>
                    <?php $count=0 ?>
                    @foreach($attslots as $as)
                        @if(isset($atts[$std->id][$as->id]))
                            <td align=center>{{ $atts[$std->id][$as->id] }}</td>
                            <?php $count++ ?>
                        @else
                            <td align=center>X</td>
                        @endif
                    @endforeach
                    <td>{{ $count }}</td>
                </tr>
                @endforeach
            </table>
        </div>
    </x-block>       
</x-att-layout>
