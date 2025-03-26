<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Delete confirmation
                <p>
                    <a class="btn btn-secondary btn-sm" href="{{ $back_link }}">Back</a>
                </p>
            </x-slot>
            <div>
                <form method="POST" action="{{ $action }}">
                    @csrf
                    @method('delete')
                    <input type='hidden' name='back_link' value="{{ $back_link }}">
                    <h4>Deletion will permanently delete the record. Are you sure to continue?</h4>
                    <button class="btn btn-danger" name="btn_delete" type="submit">Delete</button>
                </form>
            </div>
        </x-block>
    </x-container>
</x-layout>
