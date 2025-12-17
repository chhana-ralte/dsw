<x-layout>
    <x-container>
        <x-block>
            <x-slot name='heading'>
                List of Sections in the University
                <p>
                    <a class="btn btn-primary btn-sm" href="/section/create">
                        Create new
                    </a>
                </p>
            </x-slot>
            <table class="table">
                <tr>
                    <th>Sl</th>
                    <th>Section Name</th>
                </tr>
                <?php $sl=1 ?>
                @foreach($sections as $sect)
                    <tr>
                        <td>{{ $sl++ }}</td>
                        <td>
                            {{ $sect->name }}
                            @foreach($sect->sub_sections() as $subsect)
                                <p>{{ $subsect->name }}</p>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </table>
        </x-block>
    </x-container>
</x-layout>