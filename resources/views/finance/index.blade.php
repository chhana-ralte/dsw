<x-layout>
    <x-container>
        <x-block>
            <x-slot name='heading'>
                Finance related portal
            </x-slot>

        </x-block>
        <x-block class="col-sm-12 col-md-5 col-lg-3">
            <h3 class="text-center">Semester fees</h3>
            <p align="center">Semester fee payment related</p>
            @auth
                <div class="text-center">
                    <a class="btn btn-primary btn-sm" href="/semfee/">View</a>
                </div>
            @endauth
        </x-block>
    </x-container>
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $("meta[name='csrf-token']").attr('content')
            }
        });

        $('.table tr').click(function(event) {
            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });

        $("input#all").click(function(){
            $("input[name='allot_hostel_id[]']").each(function(){
                $(this).prop('checked',$("input#all").prop("checked"));
            });
        });


    });

</script>
</x-layout>
