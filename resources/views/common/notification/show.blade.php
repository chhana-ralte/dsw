<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Notification Detail
                <p>
                    <a href="/notiMaster/{{ $notification->notiMaster->id }}" class="btn btn-primary btn-sm">Back</a>
                </p>
            </x-slot>
            <form method="post" action="/notification/{{ $notification->id }}">
                @method('PUT')
                @csrf
                <div>
                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Notification No.
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="no" value="{{ old('no', $notification->no) }}"
                                class="form-control" disabled>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Date
                        </div>
                        <div class="col col-md-4">
                            <input type="date" name="dt" class="form-control"
                                value="{{ old('dt', $notification->dt) }}" disabled>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Content
                        </div>
                        <div class="col col-md-4">
                            <textarea name="content" class="form-control" disabled>{{ old('content', $notification->content) }}</textarea>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Type
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="type" class="form-control"
                                value="{{ old('type', $notification->type) }}" disabled>
                        </div>
                    </div>

                    <div class="pt-3 form-group row">
                        <div class="col col-md-4">
                            Status
                        </div>
                        <div class="col col-md-4">
                            <input type="text" name="status" class="form-control"
                                value="{{ old('status', $notification->status) }}" disabled>
                        </div>
                    </div>
                    @can('manages', App\Models\Notification::class)
                        <div class="pt-3 form-group row">
                            <div class="col col-md-4">

                            </div>
                            <div class="col col-md-4">
                                <a href="/notification/{{ $notification->id }}/edit" class="btn btn-secondary">Edit</a>
                            </div>
                        </div>
                    @endcan
                </div>
            </form>
        </x-block>
        @if (count($notification->allotments) > 0)
            <x-block>
                <x-slot name="heading">
                    New hostel allotments
                </x-slot>
                <div style="width:100%, x-overflow:auto">
                    <table class="table">
                        <tr>
                            <td>
                                Number of total allotments :
                            </td>
                            <td>
                                {{ $notification->allotments->count('id') }}
                                <a class="btn btn-primary btn-sm"
                                    href="/notification/{{ $notification->id }}/allotment">View</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Who paid fee and did admission :
                            </td>
                            <td>
                                {{ $notification->admissions(15)->count('id') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Who are llotted rooms/seats :
                            </td>
                            <td>
                                {{ $notification->allotments->count('id') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Who are declined admission/allotment :
                            </td>
                            <td>
                                {{ $notification->allotments->count('id') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </x-block>
        @endif

        @if (count($notification->sem_allots) > 0)
            <x-block>
                <x-slot name="heading">
                    Existing students continuing hostel allotments
                </x-slot>
                <div style="width:100%, x-overflow:auto">
                    <table class="table">
                        <tr>
                            <td>
                                Number of total allotments :
                            </td>
                            <td>
                                {{ $notification->sem_allots->count('id') }}
                                <a class="btn btn-primary btn-sm"
                                    href="/notification/{{ $notification->id }}/sem_allot">View</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Who paid fee and did admission :
                            </td>
                            <td>
                                {{ $notification->sem_allots->count('id') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Who are llotted rooms/seats :
                            </td>
                            <td>
                                {{ $notification->sem_allots->count('id') }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                Who are declined admission/allotment :
                            </td>
                            <td>
                                {{ $notification->sem_allots->count('id') }}
                            </td>
                        </tr>
                    </table>
                </div>
            </x-block>
        @endif
    </x-container>
    <script>
        $(document).ready(function() {
            $("input[name='start_yr']").keyup(function() {
                if ($(this).val().length >= 4) {
                    vl = parseInt($(this).val()) + 1;
                    $("input[name='end_yr']").val(vl);
                }
            });
        });
    </script>
</x-layout>
