<x-layout>
    <x-container>

        <x-block>
            <x-slot name="heading">
                <h2>Summary</h2>
                <p>
                    <a class="btn btn-secondary btn-sm" href="/requirement/list">Back</a>
                </p>

            </x-slot>
            <div style="width: 100%; overflow-x:auto">

                <table class="table table-auto">
                    <thead>
                        <tr>


                            <th>Sl</th>
                            <th>Hostel</th>
                            <th>Occupants</th>
                            <th>Requirements</th>
                            <th>Same hostel</th>
                            <th>Diff hostel</th>
                            <th>Applied</th>
                            <th>Resolved</th>
                            <th>Notified</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                                $sl = 1;

                        ?>
                        @foreach ($summary as $item)
                            <tr>

                                <td>

                                        {{ $sl++ }}

                                </td>
                                <td>
                                   {{ $item->name }}
                                </td>
                                <td>
                                   {{ $item->allot_hostels }}
                                </td>
                                <td>
                                   {{ $item->requirements }}
                                </td>
                                <td>
                                   {{ $item->same_hostel }}
                                </td>
                                <td>
                                   {{ $item->diff_hostel }}
                                </td>
                                <td>
                                   {{ $item->applied }}
                                </td>
                                <td>
                                   {{ $item->resolved }}
                                </td>
                                <td>
                                   {{ $item->notified }}
                                </td>


                            </tr>
                        @endforeach
                    </tbody>


                </table>


            </div>
        </x-block>
    </x-container>

</x-layout>
