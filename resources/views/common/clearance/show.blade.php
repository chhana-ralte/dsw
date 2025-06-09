<x-layout>
    <x-container>
        <x-block>
            <x-slot name="heading">
                Clearance form for leaving the hostel
                <p>
                    <a href="/allotment/{{ $clearance->allotment_id }}" class="btn btn-secondary btn-sm">Back to Student
                        info</a>
                </p>
            </x-slot>

            <div class="controls">
                {{-- <button onclick="window.print()" class="print-btn">Print Certificate</button>
                    <button onclick="window.print()" class="print-btn">Print Certificate</button>
                    <input type="button" value="Print Div" onclick="printDiv()">                    
                    --}}
                <button onclick="printDiv()" class="btn btn-primary">Print Certificate</button>
                <a href="/clearance/{{ $clearance->id }}/download" class="btn btn-primary">Download</a>

            </div>

            <div class="certificate" id="certificate">
                @include('common.clearance.clearance')
            </div>








            <script>
                function printDiv() {
                    // alert("asdasd");
                    let divContents = document.getElementById("certificate").innerHTML;
                    let printWindow = window.open('', '', 'height=1000, width=1000');
                    printWindow.document.write(divContents);
                    printWindow.document.close();
                    printWindow.print();
                }
            </script>



            </body>

            </html>

        </x-block>
    </x-container>
</x-layout>
